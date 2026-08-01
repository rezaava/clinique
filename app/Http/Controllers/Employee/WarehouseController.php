<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    //
    public function warehouseIndex(){
        return view('Employee.warehouses.warehouse');
    }
}
