<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;

class SiteController extends Controller
{
    public function home()
    {
        $services = Service::where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        $doctor = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })
            ->inRandomOrder()
            ->first();

        $doctorService = $doctor
            ? $doctor->services()->inRandomOrder()->first()
            : null;
            
        $doctor['ability'] = $doctorService?->name;
        return response()->json([
            'success' => true,
            'message' => 'اطلاعات صفحه اصلی با موفقیت دریافت شد.',
            'data' => [
                'services' => $services,
                'doctor' => $doctor,
            ],
        ]);
    }
}