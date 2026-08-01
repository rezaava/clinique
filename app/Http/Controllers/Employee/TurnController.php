<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TurnController extends Controller
{
    //
    public function turnIndex(){
        return view('Employee.turns.turn');
    }
}
