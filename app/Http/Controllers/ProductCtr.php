<?php

namespace App\Http\Controllers;

use App\Models\ProductMaster;
use Illuminate\Http\Request;

class ProductCtr extends Controller
{
    public function list()
    {
        $productData = ProductMaster::get();
        return view('product.list',compact('productData'));
    }
}
