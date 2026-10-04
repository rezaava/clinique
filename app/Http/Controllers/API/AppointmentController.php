<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingTimeSlot;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = User::find(6);

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
                'doctorWorkingTimeSlot.workingTimeSlot',
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
             * زمان از working_time_slots گرفته می‌شود
             */
            $startTime = null;

            if ($appointment->doctorWorkingTimeSlot) {
                $workingTimeSlot = $appointment
                    ->doctorWorkingTimeSlot
                    ->workingTimeSlot;

                if ($workingTimeSlot) {
                    $startTime = $workingTimeSlot->start_time;
                }
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
             * اگر زمان نوبت مشخص باشد،
             * تاریخ + ساعت شروع slot را با زمان فعلی مقایسه می‌کنیم.
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

                /*
                 * اگر نوبت slot نداشته باشد،
                 * فقط بر اساس تاریخ بررسی می‌کنیم.
                 */
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
         * مرتب‌سازی upcoming بر اساس تاریخ و ساعت شروع slot
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
         * مرتب‌سازی past از جدیدترین به قدیمی‌ترین
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
        $user = User::find(6);

        $appointment = Appointment::where('id', $id)
            ->where('user_id', $user->id)
            ->with([
                'transaction',
                'assignedStaff',
                'service',
                'doctorWorkingTimeSlot.workingTimeSlot',
            ])
            ->firstOrFail();

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

            $workingTimeSlot = $appointment
                ->doctorWorkingTimeSlot
                ->workingTimeSlot;

            if ($workingTimeSlot) {
                $startTime = $workingTimeSlot->start_time;
            }
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
}