<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingDay;

class SiteController extends Controller
{
    public function home()
    {
        $services = Service::where('is_active', 1)
            ->orderByDesc('id')
            ->with('category')
            ->get();

        $doctor = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })
            ->inRandomOrder()
            ->first();

        $doctorService = $doctor
            ? $doctor->services()->inRandomOrder()->first()
            : null;
            
        $doctorAvailable = $doctor->getNearestAvailableSlot();
            
        $doctor['ability'] = $doctorService?->name;
        $doctor['available'] = $doctorAvailable;
        return response()->json([
            'success' => true,
            'message' => 'اطلاعات صفحه اصلی با موفقیت دریافت شد.',
            'data' => [
                'services' => $services,
                'doctor' => $doctor,
            ],
        ]);
    }

    public function workdays()
    {
        $workdays = WorkingDay::orderBy('day')->get();

        return response()->json([
            'success' => true,
            'message' => 'روزهای کاری با موفقیت دریافت شد.',
            'data' => $workdays,
        ]);
    }
}