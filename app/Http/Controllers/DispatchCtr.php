<?php

namespace App\Http\Controllers;

use App\Models\DispatchMaster;
use App\Models\LineMaster;
use App\Models\PlantMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use Illuminate\Http\Request;

class DispatchCtr extends Controller
{

    public function list()
    {
        $lineData = LineMaster::orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        $dispatchData = DispatchMaster::join('product_masters', 'product_masters.product_id', 'dispatch_masters.product_id')->where('line_id', '0')->get();
        return view('dispatch.list', compact('dispatchData', 'lineData'));
    }

    public function update(Request $request)
    {
        foreach ($request->line_id as $dispatch_id => $line_id) {
            DispatchMaster::where('dispatch_id', $dispatch_id)->update(['line_id' => $line_id]);
        }
        return redirect()->route('dispatch');
    }

}
