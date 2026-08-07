<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdSettingController extends Controller
{
    //
    public function settingIndex()
    {
        return view('Admin.settings.setting');
    }
}
