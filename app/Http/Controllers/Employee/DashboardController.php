<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function dashboardIndex()
    {
        $appointments = Appointment::whereDate('appointment_date', Carbon::today())->get();
        $yesterdayAppointmentCount = Appointment::whereDate('appointment_date', Carbon::yesterday())->count();

        $difference = count($appointments) - $yesterdayAppointmentCount;

        return view('Employee.dashboard.dashboard', compact('appointments','yesterdayAppointmentCount','difference'));
    }
}
