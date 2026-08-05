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
        $criticalTasks = Task::where('priority' , 'critical')->whereDate('date_task', today())->get();
        $highTasks = Task::where('priority' , 'high')->whereDate('date_task', today())->get();
        $normalTasks = Task::where('priority' , 'normal')->whereDate('date_task', today())->get();
        $doneTasks = Task::where('priority' , 'done')->whereDate('date_task', today())->orderBy('time_task' , 'asc')->get();
        return view('Employee.tasks.task' , compact('criticalTasks' , 'highTasks' , 'normalTasks' , 'doneTasks'));
    }

    public function updateTask($id){
        $task = Task::where('id' , $id)->first();

        $task->priority = "done";
        $task->save();

        return redirect()->back()->with('success' , 'وضعیت وظیفه به تکمیل شده تبدیل شد');
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
            'title.required'   => 'لطفا عنوان وظیفه  را وارد کنید.',
            'date_task.required'   => 'لطفا تاریخ انجام وظیفه را وارد کنید.',
            'date_task.date_format'   => 'لطفا تاریخ انجام وظیفه را درست وارد کنید  نمونه 1405/02/01   .',
            'time_task.required'   => 'لطفا زمان انجام وظیفه را وارد کنید.',
            'time_task.date_format'   => 'لطفا زمان انجام وظیفه را مانند نمونه وارد کنید 08:00 یا 14:00.',
            'priority.required'   => 'لطفا اولویت انجام وظیفه را مشخص کنید.',
        
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
        return redirect()->back()->with('success' , 'افزودن وظیفه با موفقیت انجام شد.');
    }
}
