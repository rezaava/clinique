<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdDevicesController extends Controller
{
    //
    public function deviceIndex()
    {
        return view('Admin.devices.devices');
    }
}
