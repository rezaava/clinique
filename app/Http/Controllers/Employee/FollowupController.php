<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    //
    public function followupIndex(){
        return view('Employee.followups.followups');
    }
}
