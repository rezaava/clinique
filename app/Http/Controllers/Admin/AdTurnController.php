<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdTurnController extends Controller
{
    //
    public function turnIndex()
    {
        return view('Admin.turns.turn');
    }
}
