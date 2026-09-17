<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function det($id) {
        $user = User::find(6);
        $appointment = Appointment::where('id', $id)->where('user_id',$user->id)->with('transaction')->firstOrFail();
        return response()->json([
            'success' => true,
            'message' => 'اطلاعات نوبت با موفقیت دریافت شد.',
            'data' => [
                'appointment' => $appointment,
            ],
        ]);
    }
}
