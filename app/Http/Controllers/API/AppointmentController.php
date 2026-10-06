<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WorkingTimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = User::find(5);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر موردنظر پیدا نشد.',
            ], 404);
        }

        $appointments = Appointment::where('user_id', $user->id)
            ->whereIn('status', [
                'confirmed',
                'completed',
                'cancelled',
            ])
            ->with([
                'transaction',
                'assignedStaff',
                'service',
                'doctorWorkingTimeSlot.workingDay',
            ])
            ->get();

        $upcoming = [];
        $past = [];
        $cancelled = [];

        foreach ($appointments as $appointment) {

            /*
            * تاریخ شمسی
            */
            $appointment->appointment_date_fa = Verta::instance(
                $appointment->getRawOriginal('appointment_date')
            )->format('F d, l');

            /*
            * زمان از WorkingTimeSlot
            */
            $startTime = null;

            if ($appointment->doctorWorkingTimeSlot) {
                $startTime = $appointment->doctorWorkingTimeSlot->start_time;
            }

            $appointment->appointment_time_fa = $startTime
                ? Carbon::parse($startTime)->format('H:i')
                : null;

            /*
            * اطلاعات تخصص پزشک برای همین سرویس
            */
            if ($appointment->assignedStaff) {
                $doctorService = $appointment->assignedStaff
                    ->services()
                    ->where('services.id', $appointment->service_id)
                    ->first();

                $appointment->assignedStaff->ability =
                    $doctorService?->name;
            }

            /*
            * کنسل شده
            */
            if ($appointment->status === 'cancelled') {
                $cancelled[] = $appointment;
                continue;
            }

            /*
            * بررسی تاریخ و ساعت نوبت
            */
            if ($startTime) {

                $appointmentDateTime = Carbon::parse(
                    $appointment->getRawOriginal('appointment_date')
                )->setTimeFromTimeString(
                    Carbon::parse($startTime)->format('H:i:s')
                );

                if ($appointmentDateTime->isFuture()) {
                    $upcoming[] = $appointment;
                } else {
                    $past[] = $appointment;
                }

            } else {

                $appointmentDate = Carbon::parse(
                    $appointment->getRawOriginal('appointment_date')
                );

                if ($appointmentDate->isFuture()) {
                    $upcoming[] = $appointment;
                } else {
                    $past[] = $appointment;
                }
            }
        }

        /*
        * مرتب‌سازی upcoming
        */
        usort($upcoming, function ($a, $b) {

            $dateA = $a->getRawOriginal('appointment_date');
            $dateB = $b->getRawOriginal('appointment_date');

            if ($dateA !== $dateB) {
                return strcmp($dateA, $dateB);
            }

            $timeA = $a->appointment_time_fa ?? '23:59';
            $timeB = $b->appointment_time_fa ?? '23:59';

            return strcmp($timeA, $timeB);
        });

        /*
        * مرتب‌سازی past
        */
        usort($past, function ($a, $b) {

            $dateA = $a->getRawOriginal('appointment_date');
            $dateB = $b->getRawOriginal('appointment_date');

            if ($dateA !== $dateB) {
                return strcmp($dateB, $dateA);
            }

            $timeA = $a->appointment_time_fa ?? '00:00';
            $timeB = $b->appointment_time_fa ?? '00:00';

            return strcmp($timeB, $timeA);
        });

        return response()->json([
            'success' => true,
            'message' => 'لیست نوبت‌ها با موفقیت دریافت شد.',
            'data' => [
                'upcoming' => $upcoming,
                'past' => $past,
                'cancelled' => $cancelled,
            ],
        ]);
    }

    public function det($id)
    {
        $user = User::find(5);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر موردنظر پیدا نشد.',
            ], 404);
        }

        $appointment = Appointment::where('id', $id)
            ->where('user_id', $user->id)
            ->with([
                'transaction',
                'assignedStaff',
                'service',
                'doctorWorkingTimeSlot.workingDay',
            ])
            ->firstOrFail();

        /*
        * پزشک
        */
        $doctor = $appointment->assignedStaff;

        /*
        * تخصص پزشک برای همان سرویسی که رزرو شده
        */
        $doctorService = $doctor
            ? $doctor->services()
                ->where('services.id', $appointment->service_id)
                ->first()
            : null;

        if ($appointment->assignedStaff) {
            $appointment->assignedStaff->ability =
                $doctorService?->name;
        }

        /*
        * تاریخ شمسی
        */
        $appointment->appointment_date_fa = Verta::instance(
            $appointment->getRawOriginal('appointment_date')
        )->format('Y F d, l');

        /*
        * زمان از WorkingTimeSlot
        */
        $startTime = null;

        if ($appointment->doctorWorkingTimeSlot) {
            $startTime = $appointment->doctorWorkingTimeSlot->start_time;
        }

        $appointment->appointment_time_fa = $startTime
            ? Carbon::parse($startTime)->format('H:i')
            : null;

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات نوبت با موفقیت دریافت شد.',
            'data' => [
                'appointment' => $appointment,
            ],
        ]);
    }

    public function freetimes($date, $service)
    {
        try {
            $date = Carbon::parse($date)->startOfDay();

            if ($date->lte(Carbon::today())) {
                return response()->json([
                    'success' => false,
                    'message' => 'تاریخ باید بعد از امروز باشد.',
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'تاریخ وارد شده معتبر نیست.',
            ], 422);
        }

        $serviceModel = Service::find($service);

        if (! $serviceModel) {
            return response()->json([
                'success' => false,
                'message' => 'خدمت موردنظر پیدا نشد.',
            ], 404);
        }

        $projectDay = ($date->dayOfWeek + 1) % 7;

        $timeSlots = WorkingTimeSlot::with('workingDay')
            ->whereHas('workingDay', function ($query) use ($projectDay) {
                $query->where('day', $projectDay);
            })
            ->orderBy('start_time')
            ->get();

        $activeStatuses = [
            'pending',
            'confirmed',
            'in_progress',
        ];

        $doctors = $serviceModel->staff()
            ->with([
                'workingTimeSlots.workingDay',
            ])
            ->get()
            ->filter(function ($doctor) {
                return $doctor->hasRole('doctor');
            })
            ->values();

        $result = [];

        foreach ($doctors as $doctor) {
            $doctorSlots = $doctor->workingTimeSlots
                ->filter(function ($slot) use ($projectDay) {
                    return $slot->workingDay &&
                        (int) $slot->workingDay->day === $projectDay;
                })
                ->sortBy('start_time')
                ->values();

            if ($doctorSlots->isEmpty()) {
                continue;
            }

            $serviceRelation = $doctor->userServices
                ->where('service_id', $service)
                ->first();

            $slots = [];

            foreach ($doctorSlots as $slot) {
                $doctorWorkingTimeSlotId = $slot->pivot->id;

                $isBooked = Appointment::where(
                    'doctor_working_time_slot_id',
                    $doctorWorkingTimeSlotId
                )
                    ->whereDate(
                        'appointment_date',
                        $date->toDateString()
                    )
                    ->whereIn(
                        'status',
                        $activeStatuses
                    )
                    ->exists();

                $slots[] = [
                    'id' => $slot->id,
                    'doctor_working_time_slot_id' => $doctorWorkingTimeSlotId,
                    'start_time' => Carbon::parse(
                        $slot->start_time
                    )->format('H:i'),
                    'end_time' => Carbon::parse(
                        $slot->end_time
                    )->format('H:i'),
                    'booked' => $isBooked,
                    'past' => false,
                    'available' => ! $isBooked,
                    'status' => $isBooked
                        ? 'booked'
                        : 'available',
                ];
            }

            $result[] = [
                'doctor' => [
                    'id' => $doctor->id,
                    'first_name' => $doctor->first_name,
                    'last_name' => $doctor->last_name,
                    'full_name' => $doctor->full_name,
                ],
                'service' => [
                    'id' => $serviceModel->id,
                    'name' => $serviceModel->name,
                    'price' => $serviceRelation
                        ? (int) $serviceRelation->price
                        : null,
                ],
                'slots' => $slots,
            ];
        }

        $formattedTimeSlots = $timeSlots
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'working_day_id' => $slot->working_day_id,
                    'start_time' => Carbon::parse(
                        $slot->start_time
                    )->format('H:i'),
                    'end_time' => Carbon::parse(
                        $slot->end_time
                    )->format('H:i'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'تایم‌های آزاد و رزرو شده با موفقیت دریافت شد.',
            'data' => [
                'date' => $date->toDateString(),
                'day' => $projectDay,
                'service' => [
                    'id' => $serviceModel->id,
                    'name' => $serviceModel->name,
                ],
                'time_slots' => $formattedTimeSlots,
                'doctors' => $result,
            ],
        ]);
    }

    public function NoDepositBooking(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
            'doctor_working_time_slot_id' => ['required', 'integer', 'exists:doctor_working_time_slot,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d'],
        ]);

        try {
            $date = Carbon::createFromFormat(
                'Y-m-d',
                $data['appointment_date']
            )->startOfDay();
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'تاریخ وارد شده معتبر نیست.',
            ], 422);
        }

        if ($date->lte(Carbon::today())) {
            return response()->json([
                'success' => false,
                'message' => 'تاریخ نوبت باید بعد از امروز باشد.',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($data, $date, $request) {
                $user = User::find(5);
                $service = Service::where('is_active', true)
                    ->find($data['service_id']);

                if (! $service) {
                    throw new \Exception(
                        'خدمت موردنظر فعال نیست یا وجود ندارد.'
                    );
                }

                $doctor = $service->staff()
                    ->whereKey($data['doctor_id'])
                    ->first();

                if (! $doctor || ! $doctor->hasRole('doctor')) {
                    throw new \Exception(
                        'این پزشک این خدمت را ارائه نمی‌دهد.'
                    );
                }

                if ($doctor->pivot->price === null) {
                    throw new \Exception(
                        'قیمت این خدمت برای پزشک مشخص نشده است.'
                    );
                }

                $doctorSlot = DB::table('doctor_working_time_slot')
                    ->where('id', $data['doctor_working_time_slot_id'])
                    ->where('user_id', $doctor->id)
                    ->lockForUpdate()
                    ->first();

                if (! $doctorSlot) {
                    throw new \Exception(
                        'این بازه زمانی برای پزشک انتخاب‌شده معتبر نیست.'
                    );
                }

                $timeSlot = WorkingTimeSlot::with('workingDay')
                    ->find($doctorSlot->working_time_slot_id);

                if (! $timeSlot || ! $timeSlot->workingDay) {
                    throw new \Exception(
                        'بازه زمانی انتخاب‌شده معتبر نیست.'
                    );
                }

                $projectDay = ($date->dayOfWeek + 1) % 7;

                if ((int) $timeSlot->workingDay->day !== $projectDay) {
                    throw new \Exception(
                        'پزشک در این روز این بازه زمانی را ارائه نمی‌دهد.'
                    );
                }

                $booked = Appointment::where(
                    'doctor_working_time_slot_id',
                    $doctorSlot->id
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
                    ->lockForUpdate()
                    ->exists();

                if ($booked) {
                    throw new \Exception(
                        'این زمان قبلاً رزرو شده است.'
                    );
                }

                $price = (int) $doctor->pivot->price;

                $duration = (int) (
                    $service->duration_minutes ?: 30
                );

                $appointment = Appointment::create([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'assigned_staff_id' => $doctor->id,
                    'doctor_working_time_slot_id' => $doctorSlot->id,
                    'appointment_date' => $date->toDateString(),
                    'duration_minutes' => $duration,
                    'status' => 'pending',
                    'amount' => $price,
                    'payment_status' => 'unpaid',
                    'deposit_amount' => 0,
                ]);

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'appointment_id' => $appointment->id,
                    'type' => 'payment',
                    'payment_method' => 'other',
                    'amount' => $price,
                    'discount_amount' => 0,
                    'final_amount' => $price,
                    'paid_amount' => 0,
                    'remaining_amount' => $price,
                    'status' => 'unpaid',
                    'description' => 'رزرو نوبت بدون پرداخت بیعانه',
                    'created_by' => $user->id,
                ]);

                return [
                    'appointment' => $appointment,
                    'transaction' => $transaction,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'نوبت بدون بیعانه با موفقیت ثبت شد.',
                'data' => $result,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function DepositBooking(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
            'doctor_working_time_slot_id' => ['required', 'integer', 'exists:doctor_working_time_slot,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d'],
            'payment_method' => ['required', 'in:sep,zarinpal,zibal'],
        ]);

        try {
            $date = Carbon::createFromFormat(
                'Y-m-d',
                $data['appointment_date']
            )->startOfDay();
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'تاریخ وارد شده معتبر نیست.',
            ], 422);
        }

        if ($date->lte(Carbon::today())) {
            return response()->json([
                'success' => false,
                'message' => 'تاریخ نوبت باید بعد از امروز باشد.',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($data, $date, $request) {
                $user = User::find(5);

                $service = Service::where('is_active', true)
                    ->find($data['service_id']);

                if (! $service) {
                    throw new \Exception(
                        'خدمت موردنظر فعال نیست یا وجود ندارد.'
                    );
                }

                $doctor = $service->staff()
                    ->whereKey($data['doctor_id'])
                    ->first();

                if (! $doctor || ! $doctor->hasRole('doctor')) {
                    throw new \Exception(
                        'این پزشک این خدمت را ارائه نمی‌دهد.'
                    );
                }

                if ($doctor->pivot->price === null) {
                    throw new \Exception(
                        'قیمت این خدمت برای پزشک مشخص نشده است.'
                    );
                }

                $doctorSlot = DB::table('doctor_working_time_slot')
                    ->where('id', $data['doctor_working_time_slot_id'])
                    ->where('user_id', $doctor->id)
                    ->lockForUpdate()
                    ->first();

                if (! $doctorSlot) {
                    throw new \Exception(
                        'این بازه زمانی برای پزشک انتخاب‌شده معتبر نیست.'
                    );
                }

                $timeSlot = WorkingTimeSlot::with('workingDay')
                    ->find($doctorSlot->working_time_slot_id);

                if (! $timeSlot || ! $timeSlot->workingDay) {
                    throw new \Exception(
                        'بازه زمانی انتخاب‌شده معتبر نیست.'
                    );
                }

                $projectDay = ($date->dayOfWeek + 1) % 7;

                if ((int) $timeSlot->workingDay->day !== $projectDay) {
                    throw new \Exception(
                        'پزشک در این روز این بازه زمانی را ارائه نمی‌دهد.'
                    );
                }

                $booked = Appointment::where(
                    'doctor_working_time_slot_id',
                    $doctorSlot->id
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
                    ->lockForUpdate()
                    ->exists();

                if ($booked) {
                    throw new \Exception(
                        'این زمان قبلاً رزرو شده است.'
                    );
                }

                $price = (int) $doctor->pivot->price;

                $deposit = (int) (
                    round(($price * 0.3) / 1000) * 1000
                );

                $balance = $price - $deposit;

                $duration = (int) (
                    $service->duration_minutes ?: 30
                );

                $appointment = Appointment::create([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'assigned_staff_id' => $doctor->id,
                    'doctor_working_time_slot_id' => $doctorSlot->id,
                    'appointment_date' => $date->toDateString(),
                    'duration_minutes' => $duration,
                    'status' => 'pending',
                    'amount' => $price,
                    'payment_status' => 'partial',
                    'deposit_amount' => $deposit,
                ]);

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'appointment_id' => $appointment->id,
                    'type' => 'payment',
                    'payment_method' => 'online',
                    'amount' => $price,
                    'discount_amount' => 0,
                    'final_amount' => $price,
                    'paid_amount' => $deposit,
                    'remaining_amount' => $balance,
                    'status' => 'partial',
                    'description' => 'رزرو نوبت با پرداخت بیعانه',
                    'meta_data' => [
                        'gateway' => $data['payment_method'],
                    ],
                    'paid_at' => now(),
                    'created_by' => $user->id,
                ]);

                return [
                    'appointment' => $appointment,
                    'transaction' => $transaction,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'نوبت با بیعانه با موفقیت ثبت شد.',
                'data' => $result,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}