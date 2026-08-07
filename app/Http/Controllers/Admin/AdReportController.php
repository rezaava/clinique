<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdReportController extends Controller
{
    //
    public function reportIndex()
    {
        return view('Admin.reports.report');
    }
}
