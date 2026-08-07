<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdWarehouseController extends Controller
{
    //
    public function warehouseIndex()
    {
        return view('Admin.warehouses.warehouse');
    }
}
