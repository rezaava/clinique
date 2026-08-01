<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    //

    public function calendarIndex(){
        return view('Employee.calendar.calendar');
    }
}
