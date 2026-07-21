<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class FeedbackController extends Controller
{
    public function addFeedback(Request $request){
        $id = Auth::id();
        $validator = Validator::make($request->all(),[
            'message' => 'required'
        ]);
        try{

            $feedback = new Feedback();

            $feedback->id = $id;
            $feedback->message = $validator->validated()['mesaage'];
            
            $feedback->save();
            return response()->json(['mode'=> 'add-feedback', 'success'=>true, 'message'=> 'Feedback added'], 200);
        
        }catch(\Exception $e){
                return response()->json(['mode'=> 'add-feedback', 'success'=>false, 'message'=> "Feedback adding failed. Error : $e"], 500);
        }
        

    }
}
