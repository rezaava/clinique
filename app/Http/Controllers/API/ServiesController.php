<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiesController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        foreach ($services as $service) {
            $service->rating = $service->appointments()
                ->whereNotNull('rating')
                ->avg('rating');

            $service->reviews = $service->appointments()
                ->whereNotNull('rating')
                ->count();
        }

        return response()->json([
            'success' => true,
            'message' => 'لیست خدمات با موفقیت دریافت شد.',
            'data' => $services,
        ]);
    }

    public function show($id)
    {
        $service = Service::where('is_active', 1)->findOrFail($id);

        $service->rating = round($service->appointments()->whereNotNull('rating')->avg('rating'),1);

        $service->reviews = $service->appointments()->whereNotNull('rating')->whereNotNull('review')->count();


        $service->reviews_list = $service->appointments()
            ->with('user:id,first_name,last_name,avatar')
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->orderByDesc('reviewed_at')
            ->get()
            ->map(function ($appointment) {

                return [
                    'id' => $appointment->id,

                    'name' => trim(
                        ($appointment->user->first_name ?? '') .
                        ' ' .
                        ($appointment->user->last_name ?? '')
                    ),

                    'avatar' => $appointment->user->avatar ?? null,

                    'rating' => $appointment->rating,

                    'review' => $appointment->review,

                    'reviewed_at' => $appointment->reviewed_at,

                    'date' => $appointment->reviewed_at
                        ? $appointment->reviewed_at->diffForHumans()
                        : null,
                ];
            })
            ->values();


        $staff = $service->staff()->get();

        foreach ($staff as $person) {
            $person->staff_rating = round($person->assignedAppointments()->where('service_id', $service->id)->whereNotNull('staff_rating')->avg('staff_rating'),1);


            $person->staff_rating_count = $person->assignedAppointments()->where('service_id', $service->id)->whereNotNull('staff_rating')->count();


            $person->next_appointment = $person->assignedAppointments()
                ->where('service_id', $service->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereDate(
                    'appointment_date',
                    '>=',
                    now()->toDateString()
                )
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->first();

            $doctorService = $person->services()->inRandomOrder()->first();

            $person->skill = $doctorService?->name;
        }

        $service->faqs = $service->faqs()->orderBy('id')->get();


        $service->staff = $staff;
        
        $relatedServices = Service::where('is_active', 1)->where('id', '!=', $service->id)->inRandomOrder()->limit(3)->get();
        $service['related_services'] = $relatedServices;
        return response()->json([
            'success' => true,
            'message' => 'اطلاعات خدمت با موفقیت دریافت شد.',
            'data' => $service,
        ]);
    }
}