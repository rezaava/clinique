<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;

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
}