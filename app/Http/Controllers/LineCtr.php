<?php

namespace App\Http\Controllers;

use App\Models\LineMaster;
use App\Models\PlantMaster;
use Illuminate\Http\Request;

class LineCtr extends Controller
{

    public function list()
    {
        $plantData = PlantMaster::orderby('plant_name')->get(['plant_id', 'plant_name']);
        $lineData = LineMaster::join('plant_masters', 'plant_masters.plant_id', 'line_masters.plant_id')->orderby('plant_masters.plant_id')->orderby('line_name')->get(['line_masters.line_id', 'plant_masters.plant_name', 'line_masters.line_name', 'line_masters.created_at']);
        return view('line.list', compact('lineData', 'plantData'));
    }
    public function save(Request $request)
    {
        if (!empty($request->id)) {
            $data = LineMaster::where('line_id', $request->id)->first();
        } else {
            $data = new LineMaster;
        }
        $data->plant_id = $request->plant_id;
        $data->line_name = strtoupper($request->line_name);
        $data->created_id = Session()->get('loggedData')['login_id'];
        $data->save();
        return redirect()->route('line')->with('message', 'Successfully saved.');
    }
    public function delete($id)
    {
        LineMaster::where('line_id', $id)->delete();
        return redirect()->route('line')->with('message', 'Successfully deleted.');
    }
}
