<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdDashboardController extends Controller
{
    //
    public function dashboardIndex()
    {
        return view('Admin.dashboard.dashboard');
    }
}
