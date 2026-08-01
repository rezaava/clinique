<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    //
    public function calendarcampaignIndex(){
        return view('Employee.campaigns.campaign');
    }
}
