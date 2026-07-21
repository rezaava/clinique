<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;


class BrandController extends Controller
{
    public function createBrand(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name'=> 'required|string',
            'description'=> 'required|string'
        ]);
        try{
            $brand = new Brand();

            $brand->name = $validator->validated()['name'];
            $brand->description = $validator->validated()['description'];

            $brand->save();

            return response()->json(['mode'=>'create' ,  'success'=>true, 'message'=> 'Brand created successfully'], 200);
        }catch(\Exception $e){

            return response()->json(['mode'=>'create' ,  'success'=>false, 'message'=> "Brand failed to create. Error : $e"], 500);
        }
    }

    public function deleteBrand(Request $request, $id){
        $brand = Brand::findOrFail($id);
        
        try{
            $brand->delete();
            return response()->json(['mode'=> 'delete', 'success'=> true, 'message' => "Brand Deleted Successfully"], 200);

        }catch(\Exception $e){
            return response()->json(['mode'=> 'delete', 'success'=> false, 'message' => "Brand failed to delete. Error : $e"], 500);
        }
    }

    public function editBrand(Request $request, $id){
        $brand = Brand::findOrFail($id);

        $data = $request->input('data');

        try{
            foreach($data as $col_name => $value){
                $brand->$col_name = $value;
            }
            $brand->save();

            return response()->json(['mode'=> 'edit', 'success'=> true, 'message' => "Brand edited Successfully"], 200);
        }catch(\Exception $e){
            return response()->json(['mode'=> 'edit', 'success'=> false, 'message' => "Brand failed to edit. Error : $e"], 500);
        }
    }
}
