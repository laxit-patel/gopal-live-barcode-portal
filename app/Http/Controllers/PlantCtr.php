<?php

namespace App\Http\Controllers;

use App\Models\PlantMaster;
use Illuminate\Http\Request;

class PlantCtr extends Controller
{
    public function list()
    {
        $plantData = PlantMaster::orderby('plant_name')->get();
        return view('plant.list', compact('plantData'));
    }
    public function save(Request $request)
    {
        if (!empty($request->id)) {
            $data = PlantMaster::where('plant_id', $request->id)->first();
        } else {
            $data = new PlantMaster;
        }
        $data->plant_name = $request->plant_name;
        $data->created_id = Session()->get('loggedData')['login_id'];
        $data->save();
        return redirect()->route('plant')->with('message', 'Successfully saved.');
    }
    public function delete($id)
    {
        PlantMaster::where('plant_id', $id)->delete();
        return redirect()->route('plant')->with('message', 'Successfully deleted.');
    }
}
