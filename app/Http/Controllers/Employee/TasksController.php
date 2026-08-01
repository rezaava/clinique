<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    //
    public function taskIndex(){
        return view('Employee.tasks.task');
    }
}
