<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\User;

class SpecialistController extends Controller
{
    public function profile($id)
    {
        $doctor = User::findOrFail($id);

        if (!$doctor->hasRole('doctor')) {
            abort(404);
        }

        $appointments = Appointment::where('assigned_staff_id', $doctor->id)
            ->whereNotNull('staff_rating')
            ->get();

        $reviews = Appointment::where('assigned_staff_id', $doctor->id)
            ->whereNotNull('review')
            ->with('user')
            ->get();
        $doctorService = $doctor
            ? $doctor->services()->inRandomOrder()->first()
            : null;

        $doctor['ability'] = $doctorService;
        $doctor->load(['services','credentials',]);
        $doctor['rating'] = $appointments->avg('staff_rating')? round($appointments->avg('staff_rating'), 1): 0;
        $doctor['rating_count'] = $appointments->count();
        $doctor['client_count'] = Appointment::where('assigned_staff_id',$doctor->id)->count();
        $doctor['reviews'] = $reviews;

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات پروفایل دکتر با موفقیت دریافت شد.',
            'data' => [
                'doctor' => $doctor,
            ],
        ]);
    }
}
