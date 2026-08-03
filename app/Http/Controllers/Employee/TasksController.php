<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Auth;

class TasksController extends Controller
{
    //
    public function taskIndex(){
        return view('Employee.tasks.task');
    }

    public function taskAdd(Request $req){
        $task = new Task();

        $task->title = $req->title;
        $task->date_task = $req->date_task;
        $task->time_task = $req->time_task;
        $task->priority = $req->priority;
        $task->status = 0;
        $task->user_id = Auth::user()->id;
        $task->save();
        return redirect()->back();
    }
}
