<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class TasksController extends Controller
{
    //
    public function taskIndex(){
        return view('Employee.tasks.task');
    }

    public function taskAdd(Request $req){

        $data = $req->all();

        $rules = [
            'title'   => 'required',
            'date_task'    => 'required|date_format:Y-m-d',
            'time_task'  => 'required|date_format:H:i',
            'priority'  => 'required',
        ];

        $messages = [
            'title.required'   => 'لطفا عنوان تسک  را وارد کنید.',
            'date_task.required'   => 'لطفا تاریخ انجام تسک را وارد کنید.',
            'date_task.date_format'   => 'لطفا تاریخ انجام تسک را درست وارد کنید  نمونه 1405/02/01   .',
            'time_task.required'   => 'لطفا زمان انجام تسک را وارد کنید.',
            'time_task.date_format'   => 'لطفا زمان انجام تسک را مانند نمونه وارد کنید 08:00 یا 14:00.',
            'priority.required'   => 'لطفا اولویت انجام تسک را مشخص کنید.',
        
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $task = new Task();

        $task->title = $req->title;
        $task->date_task = $req->date_task;
        $task->time_task = $req->time_task;
        $task->priority = $req->priority;
        $task->status = 0;
        $task->user_id = Auth::user()->id;
        $task->save();
        return redirect()->back()->with('success' , 'افزودن تسک با موفقیت انجام شد.');
    }
}
