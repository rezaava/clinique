<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    //
    public function financialIndex(){
        return view('Employee.financials.financial');
    }
}
