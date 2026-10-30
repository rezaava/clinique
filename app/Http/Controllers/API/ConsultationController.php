<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Service;
use App\Models\WorkingTimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'photo' => [
                'nullable',
                'image',
                'max:5120',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
            'doctor_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'doctor_working_time_slot_id' => [
                'nullable',
                'integer',
                'exists:doctor_working_time_slot,id',
            ],
            'consultation_date' => [
                'nullable',
                'date_format:Y-m-d',
            ],
            'any_time' => [
                'nullable',
                'boolean',
            ],
            'type' => [
                'nullable',
                'in:online,in_person,phone',
            ],
        ]);

        $user = $request->user();
        $hasDoctor = ! empty($data['doctor_id']);
        $hasSlot = ! empty($data['doctor_working_time_slot_id']);
        $hasDate = ! empty($data['consultation_date']);
        $hasExplicitTime = $hasSlot && $hasDate;

        if ($hasSlot !== $hasDate) {
            return response()->json([
                'success' => false,
                'message' => 'برای انتخاب تایم مشخص، تاریخ و تایم را با هم انتخاب کنید.',
            ], 422);
        }

        if ($hasExplicitTime && ! $hasDoctor) {
            return response()->json([
                'success' => false,
                'message' => 'برای انتخاب تایم مشخص، ابتدا متخصص را انتخاب کنید.',
            ], 422);
        }

        $anyTime = (bool) ($data['any_time'] ?? ! $hasExplicitTime);

        if ($hasExplicitTime && $anyTime) {
            return response()->json([
                'success' => false,
                'message' => 'نمی‌توانید هم‌زمان تایم مشخص و هر زمان خالی را انتخاب کنید.',
            ], 422);
        }

        $photoPath = null;

        try {
            $service = Service::where('is_active', true)
                ->find($data['service_id']);

            if (! $service) {
                return response()->json([
                    'success' => false,
                    'message' => 'خدمت موردنظر فعال نیست یا وجود ندارد.',
                ], 422);
            }

            $price = (float) ($service->consultation_price ?? 0);

            if ($price < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'قیمت مشاوره معتبر نیست.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | ذخیره عکس در پوشه public پروژه
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('photo')) {
                $directory = ('consultations');

                if (! is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                $file = $request->file('photo');
                $filename = $file->hashName();

                $file->move($directory, $filename);

                $photoPath = 'consultations/'.$filename;
            }

            /*
            |--------------------------------------------------------------------------
            | ثبت درخواست مشاوره
            |--------------------------------------------------------------------------
            */

            $consultation = DB::transaction(function () use (
                $data,
                $user,
                $service,
                $price,
                $photoPath,
                $hasDoctor,
                $hasExplicitTime,
                $anyTime
            ) {
                $doctor = null;
                $doctorSlot = null;
                $consultationDate = null;

                /*
                |--------------------------------------------------------------------------
                | دریافت پزشکان ارائه‌دهنده خدمت
                |--------------------------------------------------------------------------
                */

                $doctorsQuery = $service->staff()
                    ->with('workingTimeSlots.workingDay');

                if ($hasDoctor) {
                    $doctorsQuery->whereKey($data['doctor_id']);
                }

                $doctors = $doctorsQuery
                    ->get()
                    ->filter(function ($item) {
                        return $item->hasRole('doctor');
                    })
                    ->values();

                if ($doctors->isEmpty()) {
                    throw new \RuntimeException(
                        'هیچ پزشک معتبری برای ارائه این خدمت پیدا نشد.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | بررسی تایم انتخابی کاربر
                |--------------------------------------------------------------------------
                */

                if ($hasExplicitTime) {
                    $consultationDate = Carbon::createFromFormat(
                        'Y-m-d',
                        $data['consultation_date']
                    )->startOfDay();

                    if ($consultationDate->lte(Carbon::today())) {
                        throw new \RuntimeException(
                            'تاریخ مشاوره باید بعد از امروز باشد.'
                        );
                    }

                    $doctor = $doctors->firstWhere(
                        'id',
                        (int) $data['doctor_id']
                    );

                    if (! $doctor) {
                        throw new \RuntimeException(
                            'این پزشک خدمت موردنظر را ارائه نمی‌دهد.'
                        );
                    }

                    $doctorSlot = DB::table('doctor_working_time_slot')
                        ->where(
                            'id',
                            $data['doctor_working_time_slot_id']
                        )
                        ->where('user_id', $doctor->id)
                        ->lockForUpdate()
                        ->first();

                    if (! $doctorSlot) {
                        throw new \RuntimeException(
                            'تایم انتخاب‌شده برای این پزشک معتبر نیست.'
                        );
                    }

                    $timeSlot = WorkingTimeSlot::with('workingDay')
                        ->find($doctorSlot->working_time_slot_id);

                    if (! $timeSlot || ! $timeSlot->workingDay) {
                        throw new \RuntimeException(
                            'بازه زمانی انتخاب‌شده معتبر نیست.'
                        );
                    }

                    $weekday = (
                        $consultationDate->dayOfWeek + 1
                    ) % 7;

                    if ((int) $timeSlot->workingDay->day !== $weekday) {
                        throw new \RuntimeException(
                            'این تایم در روز انتخاب‌شده برای پزشک تعریف نشده است.'
                        );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | بررسی رزرو قبلی
                |--------------------------------------------------------------------------
                */

                $isBooked = function (
                    int $slotId,
                    Carbon $date
                ): bool {
                    $appointmentBooked = Appointment::where(
                        'doctor_working_time_slot_id',
                        $slotId
                    )
                        ->whereDate(
                            'appointment_date',
                            $date->toDateString()
                        )
                        ->whereIn('status', [
                            'pending',
                            'confirmed',
                            'in_progress',
                        ])
                        ->exists();

                    if ($appointmentBooked) {
                        return true;
                    }

                    return Consultation::where(
                        'doctor_working_time_slot_id',
                        $slotId
                    )
                        ->whereDate(
                            'consultation_date',
                            $date->toDateString()
                        )
                        ->whereIn('status', [
                            'pending',
                            'assigned',
                            'in_progress',
                        ])
                        ->exists();
                };

                /*
                |--------------------------------------------------------------------------
                | پیدا کردن نزدیک‌ترین تایم آزاد
                |--------------------------------------------------------------------------
                */

                if (! $hasExplicitTime) {
                    $found = false;
                    $candidateDate = Carbon::tomorrow()->startOfDay();

                    for ($dayIndex = 0; $dayIndex < 90; $dayIndex++) {
                        $weekday = (
                            $candidateDate->dayOfWeek + 1
                        ) % 7;

                        foreach ($doctors as $candidateDoctor) {
                            $slots = $candidateDoctor->workingTimeSlots
                                ->filter(function ($slot) use ($weekday) {
                                    return $slot->workingDay &&
                                        (int) $slot->workingDay->day === $weekday;
                                })
                                ->sortBy('start_time')
                                ->values();

                            foreach ($slots as $slot) {
                                $pivotId = (int) $slot->pivot->id;

                                $lockedSlot = DB::table(
                                    'doctor_working_time_slot'
                                )
                                    ->where('id', $pivotId)
                                    ->where('user_id', $candidateDoctor->id)
                                    ->lockForUpdate()
                                    ->first();

                                if (! $lockedSlot) {
                                    continue;
                                }

                                if ($isBooked($pivotId, $candidateDate)) {
                                    continue;
                                }

                                $doctor = $candidateDoctor;
                                $doctorSlot = $lockedSlot;
                                $consultationDate = $candidateDate->copy();

                                $found = true;

                                break 3;
                            }
                        }

                        $candidateDate->addDay();
                    }

                    if (! $found) {
                        throw new \RuntimeException(
                            'در ۹۰ روز آینده تایم آزادی برای مشاوره پیدا نشد.'
                        );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | بررسی نهایی تایم انتخابی
                |--------------------------------------------------------------------------
                */

                if ($isBooked(
                    (int) $doctorSlot->id,
                    $consultationDate
                )) {
                    throw new \RuntimeException(
                        'این تایم قبلاً رزرو شده است. لطفاً تایم دیگری انتخاب کنید.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | ذخیره اطلاعات فرم
                |--------------------------------------------------------------------------
                */

                $consultation = new Consultation;

                $consultation->user_id = $user?->id;
                $consultation->service_id = $service->id;

                $consultation->name = $data['name'];
                $consultation->phone = $data['phone'];

                $consultation->type = $data['type'] ?? 'in_person';
                $consultation->description = $data['description'] ?? null;
                $consultation->photo_path = $photoPath;
                $consultation->notes = $data['notes'] ?? null;

                $consultation->assigned_to = $doctor->id;
                $consultation->doctor_working_time_slot_id = $doctorSlot->id;
                $consultation->consultation_date = $consultationDate->toDateString();

                $consultation->any_time = $anyTime;
                $consultation->price = $price;

                $consultation->status = 'pending';
                $consultation->assigned_at = now();

                $consultation->save();

                return $consultation->load('service', 'assignedTo');
            });

            /*
            |--------------------------------------------------------------------------
            | پاسخ موفق
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'message' => 'درخواست مشاوره با موفقیت ثبت شد.',
                'data' => [
                    'consultation' => $consultation,
                    'photo_url' => $consultation->photo_path
                        ? asset($consultation->photo_path)
                        : null,
                ],
            ], 201);
        } catch (\Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | حذف عکس در صورت شکست ثبت درخواست
            |--------------------------------------------------------------------------
            */

            if ($photoPath && file_exists(($photoPath))) {
                @unlink(($photoPath));
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
