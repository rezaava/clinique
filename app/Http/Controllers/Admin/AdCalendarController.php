<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdCalendarController extends Controller
{
    public function calendarIndex(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->date) : Carbon::today();
        $dateStr = $date->toDateString();

        $allAppointments = Appointment::whereDate('appointment_date', $dateStr)
            ->with(['service', 'user', 'assignedStaff'])
            ->get();

        $stats = $this->buildStats($allAppointments);
        $doctors = $this->getDoctors();
        $doctors = $this->buildDoctorHeaders($doctors);
        $appointments = $this->buildAppointments($allAppointments, $doctors, $request);
        $waitList = $this->getWaitList($dateStr);

        return view('Admin.calendar.calendar', compact(
            'stats',
            'doctors',
            'appointments',
            'waitList'
        ));
    }

    // ======================== لیست انتظار ========================

    private function getWaitList($dateStr)
    {
        return Appointment::where('status', 'pending')
            ->with(['user', 'service'])
            ->orderBy('appointment_time')
            ->limit(5)
            ->get()
            ->map(fn($a) => (object) [
                'init' => mb_substr($a->user?->first_name ?? 'ن', 0, 1) . '‌' . mb_substr($a->user?->last_name ?? 'م', 0, 1),
                'name' => trim(($a->user?->first_name ?? '') . ' ' . ($a->user?->last_name ?? '')),
                'prio' => 'med',
                'prioL' => 'متوسط',
                'sub' => ($a->service?->name ?? 'خدمت') . ' · حدود ' . rand(15, 55) . ' دقیقه انتظار',
            ]);
    }

    // ======================== متدهای کمکی ========================

    private function getDoctors()
    {
        return User::whereHas('roles', function ($q) {
            $q->where('name', 'doctor');
        })->get();
    }

    private function buildDoctorHeaders($doctors)
    {
        $colors = ['#2563eb', '#4f46e5', '#059669', '#ea580c', '#7c3aed', '#dc2626'];

        return $doctors->map(function ($doc, $index) use ($colors) {
            $init = mb_substr($doc->first_name, 0, 1) . '‌' . mb_substr($doc->last_name, 0, 1);
            return (object) [
                'id' => $doc->id,
                'init' => $init,
                'name' => 'دکتر ' . $doc->first_name . ' ' . $doc->last_name,
                'spec' => $doc->specialization ?? 'متخصص پوست و زیبایی',
                'count' => 0,
                'color' => $colors[$index % count($colors)],
            ];
        });
    }

    private function buildAppointments($allAppointments, $doctors, $request)
    {
        $items = collect();

        foreach ($allAppointments as $appt) {
            $colIndex = $doctors->search(fn($doc) => $doc->id === $appt->assigned_staff_id);

            if ($colIndex === false) {
                continue;
            }

            $startHour = $this->toDecimalHour($appt->appointment_time);
            $durHours = ($appt->service->duration_minutes ?? 30) / 60;

            $items->push((object) [
                'col' => $colIndex,
                'start' => $startHour,
                'dur' => $durHours,
                'init' => mb_substr($appt->user->first_name ?? 'ن', 0, 1),
                'name' => ($appt->user->first_name ?? '') . ' ' . ($appt->user->last_name ?? ''),
                'treat' => $appt->service->name ?? 'خدمت',
                'room' => 'اتاق ' . rand(1, 4),
                'c' => $this->statusClass($appt->status),
                'dot' => $this->statusDot($appt->status),
                'vip' => ($appt->user->tier_id ?? 0) == 3,
                'confirm' => $appt->status === 'confirmed',
                'selected' => ($request->get('appointment') == $appt->id),
            ]);
        }

        return $items;
    }

    private function buildStats($appointments)
    {
        $totalIncome = $appointments->where('status', 'completed')->sum('amount');
        $total = $appointments->count();
        $completed = $appointments->where('status', 'completed')->count();
        $cancelled = $appointments->where('status', 'cancelled')->count();
        $noShow = $appointments->where('status', 'no_show')->count();
        $pending = $appointments->where('status', 'pending')->count();

        return [
            (object) ['title' => 'درآمد امروز', 'icon' => 'dollar', 'color' => 'green', 'val' => number_format($totalIncome) . ' ت', 'sub' => $totalIncome ? '۱۲٪+ نسبت به دیروز' : 'هیچ درآمدی ثبت نشده', 'cls' => $totalIncome ? 'up' : ''],
            (object) ['title' => 'نوبت‌ها', 'icon' => 'appointments', 'color' => 'brand', 'val' => (string) $total, 'sub' => $completed . ' انجام‌شده', 'cls' => ''],
            (object) ['title' => 'بازه‌های آزاد', 'icon' => 'clock', 'color' => 'teal', 'val' => '۶', 'sub' => 'بعدی ساعت ۱۲:۳۰', 'cls' => ''],
            (object) ['title' => 'لغوشده', 'icon' => 'xcircle', 'color' => 'red', 'val' => (string) $cancelled, 'sub' => $cancelled . ' مورد امروز', 'cls' => ''],
            (object) ['title' => 'عدم‌حضور', 'icon' => 'warn', 'color' => 'orange', 'val' => (string) $noShow, 'sub' => $noShow ? 'توماس گرنت' : '—', 'cls' => $noShow ? 'warn' : ''],
            (object) ['title' => 'در انتظار', 'icon' => 'hourglass', 'color' => 'amber', 'val' => (string) $pending, 'sub' => 'تقریباً ' . ($pending * 15) . ' تا ' . ($pending * 55) . ' دقیقه', 'cls' => ''],
        ];
    }

    private function toDecimalHour($time)
    {
        if (strpos($time, ' ') !== false) {
            $time = explode(' ', $time)[1];
        }
        [$h, $m] = explode(':', $time);
        return (int) $h + (int) $m / 60;
    }

    private function statusClass($status)
    {
        $map = [
            'pending' => 'c-amber',
            'confirmed' => 'c-blue',
            'in_progress' => 'c-purple',
            'completed' => 'c-green',
            'cancelled' => 'c-red',
            'no_show' => 'c-red',
        ];
        return $map[$status] ?? 'c-gray';
    }

    private function statusDot($status)
    {
        $map = [
            'pending' => '#f59e0b',
            'confirmed' => '#2563eb',
            'in_progress' => '#7c3aed',
            'completed' => '#059669',
            'cancelled' => '#dc2626',
            'no_show' => '#dc2626',
        ];
        return $map[$status] ?? '#6b7280';
    }
}