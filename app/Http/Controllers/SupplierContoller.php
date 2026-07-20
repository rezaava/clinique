<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class UserContoller extends Controller
{
    public function createSupplier(Request $request) {
    $validated_data = Validator::make($request->all(), [
      'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:20|unique:users',
            'email' => 'nullable|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'national_code' => 'nullable|string|size:10|unique:users',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'address'=>     'nullable|string',

    ]);

    if($validated_data->fails()){
        return back()->withErrors($validated_data)->withInput();
    }
    
    try{
      $user = User::create($validated_data);
      Role::create([
        'role_id' => 5,
        'user_id' => $user->id,
      ]);
      return response()->json(
        ['mode'=>'create'   ,'success'=>true, 'msg'=>'']
      );
    }
    catch(\Exception $e){
      return response()->json(
        ['mode'=>'create'   ,'success'=>false, 'msg'=>'Error is'. $e]);
    }
  }

  public function deleteSupplier(Request $request, $id) {

    $supp = User::findOrFail($id);
    if(!$supp){
      return response()->json(
        ['mode'=>'delete',  'success'=>false, 'msg'=>'user not found']
      );
    }
    else{
      try{
        $supp->deleted_at = Carbon::now()->timestamp;
        $supp->save();
        return response()->json(['mode'=>'delete',  'success'=>true,  'msg' => 'User deleted successfulyy']);}
      catch(\Exception $e)
      {
        return response()->json(['mode'=>'delete',  'success'=>false,  'msg' => 'Error is'. $e]);
      }
    
      }
      
    }
    
  public function editSupplier(Request $request /* -> شامل نام ستون و  داده ی جدید data*/) {
    $supp = User::where($request->$column_name, $request->$column_data)->first();
    if(!$supp){
      return response()->json(['mode'=>'edit', 'success'=>false, 'msg'=>'user not found']);
    }
    else{
      try{
        foreach($request->$data as $col_name -> $value){
          $supp->col_name -> $value;
        }
        $supp->save();
        return response()->json(['mode'=>'edit', 'success'=>true, 'msg'=>'']);
        }
        catch(\Exception $e){
          return response()->json(['mode'=>'edit', 'success'=>false, 'msg'=>'Error is'. $e]);
        }
    }
  }
}
