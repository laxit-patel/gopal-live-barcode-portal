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
        $plantData = PlantMaster::all();
        $dispatchData = DispatchMaster::join('order_masters', 'order_masters.so_po_no', 'dispatch_masters.so_po_no')->get();
        return view('dispatch.list', compact('dispatchData', 'lineData','plantData'));
    }

    public function update(Request $request)
    {
        foreach ($request->line_id as $dispatch_id => $line_id) {
            DispatchMaster::where('dispatch_id', $dispatch_id)->update(['line_id' => $line_id]);
        }
        return redirect()->route('dispatch');
    }

    public function updateLine(Request $request)
    {
        $request->validate([
            'dispatch_id' => 'required',
            'plant_id' => 'required',
            'line_id' => 'required'
        ]);

        DispatchMaster::where('dispatch_id', $request->dispatch_id)->update([
            'line_id' => $request->line_id,
            'plant_id' => $request->plant_id
        ]);
        return redirect()-`>route('dispatch');
    }

}
