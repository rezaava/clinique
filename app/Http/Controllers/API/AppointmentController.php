<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingTimeSlot;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;

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

        $serviceModel = Service::findOrFail($service);

        /*
        * تبدیل روز میلادی به شماره روز پروژه
        *
        * Carbon:
        * Sunday    = 0
        * Monday    = 1
        * Tuesday   = 2
        * Wednesday = 3
        * Thursday  = 4
        * Friday    = 5
        * Saturday  = 6
        *
        * Project:
        * Saturday  = 0
        * Sunday    = 1
        * Monday    = 2
        * Tuesday   = 3
        * Wednesday = 4
        * Thursday  = 5
        * Friday    = 6
        */
        $projectDay = ($date->dayOfWeek + 1) % 7;

        /*
        * دریافت بازه‌های زمانی تعریف‌شده برای این روز
        */
        $timeSlots = WorkingTimeSlot::whereHas('workingDay', function ($query) use ($projectDay) {
            $query->where('day', $projectDay);
        })
            ->orderBy('start_time')
            ->get();

        /*
        * وضعیت‌هایی که یعنی نوبت گرفته شده
        */
        $activeStatuses = [
            'pending',
            'confirmed',
            'in_progress',
        ];

        /*
        * دکترهایی که:
        * 1. نقش doctor دارند
        * 2. خدمت موردنظر را ارائه می‌دهند
        * 3. در این روز تایم کاری دارند
        */
        $doctors = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })
            ->whereHas('userServices', function ($query) use ($service) {
                $query->where('service_id', $service);
            })
            ->whereHas('workingTimeSlots', function ($query) use ($projectDay) {
                $query->whereHas('workingDay', function ($query) use ($projectDay) {
                    $query->where('day', $projectDay);
                });
            })
            ->with([
                'userServices' => function ($query) use ($service) {
                    $query->where('service_id', $service);
                },
                'workingTimeSlots' => function ($query) use ($projectDay) {
                    $query->whereHas('workingDay', function ($query) use ($projectDay) {
                        $query->where('day', $projectDay);
                    })
                        ->orderBy('start_time');
                },
            ])
            ->get();

        $result = [];

        foreach ($doctors as $doctor) {
            $serviceRelation = $doctor->userServices->first();

            $slots = [];

            foreach ($doctor->workingTimeSlots as $slot) {
                /*
                * پیدا کردن رکورد واسط
                * doctor_working_time_slot
                */
                $doctorWorkingTimeSlotId = DB::table('doctor_working_time_slot')
                    ->where('user_id', $doctor->id)
                    ->where('working_time_slot_id', $slot->id)
                    ->value('id');

                if (! $doctorWorkingTimeSlotId) {
                    continue;
                }

                /*
                * بررسی رزرو بودن تایم در تاریخ موردنظر
                */
                $appointment = Appointment::where(
                    'doctor_working_time_slot_id',
                    $doctorWorkingTimeSlotId
                )
                    ->whereDate(
                        'appointment_date',
                        $date->toDateString()
                    )
                    ->whereIn('status', $activeStatuses)
                    ->first();

                /*
                * اگر تاریخ امروز باشد و ساعت گذشته باشد،
                * تایم دیگر قابل رزرو نیست.
                */
                $slotStart = Carbon::parse(
                    $date->toDateString().' '.$slot->start_time
                );

                $isPast = $date->isToday() && $slotStart->lt(now());

                $isBooked = $appointment !== null;

                $slots[] = [
                    'id' => $slot->id,
                    'doctor_working_time_slot_id' => $doctorWorkingTimeSlotId,
                    'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                    'booked' => $isBooked,
                    'past' => $isPast,
                    'available' => ! $isBooked && ! $isPast,
                    'status' => $isBooked
                        ? 'booked'
                        : ($isPast ? 'past' : 'available'),
                ];
            }

            if (count($slots) === 0) {
                continue;
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

        /*
        * آماده‌سازی بازه‌های زمانی
        */
        $formattedTimeSlots = $timeSlots->map(function ($slot) {
            return [
                'id' => $slot->id,
                'working_day_id' => $slot->working_day_id,
                'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
            ];
        })->values();

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