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
            ->whereIn('status', ['confirmed','completed','cancelled',])
            ->with('transaction', 'assignedStaff', 'service')
            ->get();

        $upcoming = [];
        $past = [];
        $cancelled = [];

        foreach ($appointments as $appointment) {
            $appointment->appointment_date_fa = Verta::instance(
                $appointment->getRawOriginal('appointment_date')
            )->format('F d, l');

            $appointment->appointment_time_fa = Verta::instance(
                $appointment->getRawOriginal('appointment_time')
            )->format('H:i');

            if ($appointment->assignedStaff) {
                $doctorService = $appointment->assignedStaff
                    ->services()
                    ->where('services.id', $appointment->service_id)
                    ->first();

                $appointment->assignedStaff->ability = $doctorService?->name;
            }

            if ($appointment->status === 'cancelled') {
                $cancelled[] = $appointment;
                continue;
            }

            $appointmentDateTime = Carbon::parse(
                $appointment->getRawOriginal('appointment_date')
            )->setTimeFromTimeString(
                Carbon::parse(
                    $appointment->getRawOriginal('appointment_time')
                )->format('H:i:s')
            );

            if ($appointmentDateTime->isFuture()) {
                $upcoming[] = $appointment;
            } else {
                $past[] = $appointment;
            }
        }

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
            ->with('transaction', 'assignedStaff', 'service')
            ->firstOrFail();

        $doctor = $appointment->assignedStaff;

        $doctorService = $doctor
            ? $doctor->services()->inRandomOrder()->first()
            : null;

        if ($appointment->assignedStaff) {
            $appointment->assignedStaff['ability'] = $doctorService->name;
        }

        $appointment->appointment_date_fa = Verta::instance(
            $appointment->getRawOriginal('appointment_date')
        )->format('Y F d, l');

        $appointment->appointment_time_fa = Verta::instance(
            $appointment->getRawOriginal('appointment_time')
        )->format('H:i');

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات نوبت با موفقیت دریافت شد.',
            'data' => [
                'appointment' => $appointment,
            ],
        ]);
    }
}
