<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\JsonResponse;

class ServiesController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', 1)
            ->orderByDesc('id')
            ->with('category')
            ->get();

        $category = ServiceCategory::get();

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
            'category' => $category,
        ]);
    }

    public function show($id)
    {
        $service = Service::where('is_active', 1)
            ->findOrFail($id);

        /*
         * امتیاز کلی خدمت
         */
        $service->rating = round(
            $service->appointments()
                ->whereNotNull('rating')
                ->avg('rating'),
            1
        );

        /*
         * تعداد نظرات
         */
        $service->reviews = $service->appointments()
            ->whereNotNull('rating')
            ->whereNotNull('review')
            ->count();

        /*
         * لیست نظرات
         */
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

        /*
         * پزشکان / پرسنل ارائه‌دهنده خدمت
         */
        $staff = $service->staff()->get();

        foreach ($staff as $person) {

            /*
             * میانگین امتیاز پزشک برای همین خدمت
             */
            $person->staff_rating = round(
                $person->assignedAppointments()
                    ->where('service_id', $service->id)
                    ->whereNotNull('staff_rating')
                    ->avg('staff_rating'),
                1
            );

            /*
             * تعداد امتیازهای پزشک برای همین خدمت
             */
            $person->staff_rating_count = $person->assignedAppointments()
                ->where('service_id', $service->id)
                ->whereNotNull('staff_rating')
                ->count();

            /*
             * نزدیک‌ترین نوبت آزاد پزشک
             *
             * زمان از working_time_slots گرفته می‌شود
             * و دیگر appointment_time وجود ندارد.
             */
            $person->next_appointment = $person->getNearestAvailableSlot();

            /*
             * تخصص / مهارت پزشک
             */
            $doctorService = $person->services()
                ->inRandomOrder()
                ->first();

            $person->skill = $doctorService?->name;
        }

        /*
         * سوالات متداول
         */
        $service->faqs = $service->faqs()
            ->orderBy('id')
            ->get();

        /*
         * مناسب برای چه کسانی
         */
        $service->suitabilities = $service->suitabilities()
            ->orderBy('id')
            ->get();

        /*
         * مراحل درمان
         */
        $service->treatmentSteps = $service->treatmentSteps()
            ->orderBy('id')
            ->get();

        /*
         * انتظارات
         */
        $service->expectations = $service->expectations()
            ->orderBy('id')
            ->get();

        /*
         * مراقبت‌های بعد از درمان
         */
        $service->aftercares = $service->aftercares()
            ->orderBy('id')
            ->get();

        /*
         * پزشکان
         */
        $service->staff = $staff;

        /*
         * خدمات مرتبط
         */
        $relatedServices = Service::where('is_active', 1)
            ->where('id', '!=', $service->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $service['related_services'] = $relatedServices;

        return response()->json([
            'success' => true,
            'message' => 'اطلاعات خدمت با موفقیت دریافت شد.',
            'data' => $service,
        ]);
    }
}