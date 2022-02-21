<?php

namespace App\Http\Controllers;

use App\Models\BarcodeMachineMaster;
use App\Models\LineMaster;
use App\Models\PlantMaster;
use Illuminate\Http\Request;

class BarcodeCtr extends Controller
{
    public function list()
    {
        $plantData = PlantMaster::orderby('plant_name')->get(['plant_id', 'plant_name']);
        $lineData = LineMaster::orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        $barcodeData = BarcodeMachineMaster::join('plant_masters', 'plant_masters.plant_id', 'barcode_machine_masters.plant_id')
            ->join('line_masters', 'line_masters.line_id', 'barcode_machine_masters.line_id')
            ->get(['barcode_machine_masters.machine_id', 'barcode_machine_masters.type', 'barcode_machine_masters.ip_address','barcode_machine_masters.port', 'plant_masters.plant_name', 'barcode_machine_masters.plant_id', 'line_masters.line_name', 'barcode_machine_masters.created_at']);
        return view('barcode.list', compact('barcodeData', 'plantData', 'lineData'));
    }
    public function save(Request $request)
    {
        $request->validate([
            'ip_address' => 'unique:barcode_machine_masters,ip_address',
            'line_id' => 'unique:barcode_machine_masters,line_id',
        ]);
        if (!empty($request->id)) {
            $data = BarcodeMachineMaster::where('machine_id', $request->id)->first();
        } else {
            $data = new BarcodeMachineMaster;
        }
        $data->type = $request->type;
        $data->port = $request->port;
        $data->ip_address = $request->ip_address;
        $data->plant_id = $request->plant_id;
        $data->line_id = $request->line_id;
        $data->created_id = Session()->get('loggedData')['login_id'];
        $data->save();
        return redirect()->route('barcode')->with('message', 'Successfully saved.');
    }
    public function delete($id)
    {
        BarcodeMachineMaster::where('machine_id', $id)->delete();
        return redirect()->route('barcode')->with('message', 'Successfully deleted.');
    }
}
