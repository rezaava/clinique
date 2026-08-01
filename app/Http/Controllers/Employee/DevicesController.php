<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    //
    public function deviceIndex(){
        return view('Employee.devices.devices');
    }
}
