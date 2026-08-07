<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdFinancialController extends Controller
{
    //
    public function financialIndex()
    {
        return view('Admin.financials.financial');
    }
}
