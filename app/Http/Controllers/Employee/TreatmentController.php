<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    //
    public function treatmentIndex(){
        return view('Employee.treatments.treatment');
    }
}
