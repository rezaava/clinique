<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdPatientController extends Controller
{
    //
    public function patientIndex()
    {
        return view('Admin.patients.patient');
    }
}
