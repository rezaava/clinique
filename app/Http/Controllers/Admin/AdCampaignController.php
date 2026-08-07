<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdCampaignController extends Controller
{
    //
    public function campaignIndex()
    {
        return view('Admin.campaigns.campaign');
    }
}
