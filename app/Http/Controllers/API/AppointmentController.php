<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Hekmatinasser\Verta\Verta;

class AppointmentController extends Controller
{
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
