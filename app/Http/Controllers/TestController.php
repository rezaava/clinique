<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $service = Service::get();
        return $service;
        return view('client.index');
    }
}
