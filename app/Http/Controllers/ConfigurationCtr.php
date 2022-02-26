<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\RawDispatchMaster;
use App\Models\RawPackingMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigurationCtr extends Controller
{
    public function list()
    {
        $data = Configuration::first();
        return view('configuration.list', compact('data'));
    }
    public function save(Request $request)
    {
        if (!empty(>$request->id)) {
            $data = Configuration::where('configurations_id', $request->id)->first();
        } else {
            $data = new Configuration;
        }
        $data->productionVoucher = $request->productionVoucher;
        // $data->dispatchVoucher = $request->dispatchVoucher;
        $data->rawPacking = $request->rawPacking;
        $data->created_id = Session()->get('loggedData')['login_id'];
        $data->save();
        // if ($request->rawPacking != 'Off' && !empty($request->rawPacking)) {
        //     Artisan::call('Production:RawPacking');
        //     return true;
        // }
        return redirect()->route('configuration')->with('message', 'Successfully saved.');
    }

    public function rawProductionClear()
    {
        RawPackingMaster::truncate();
        return redirect()->route('configuration')->with('message', 'Cleared Data');
    }

    public function rawDispatchClear()
    {
        RawDispatchMaster::truncate();
        return redirect()->route('configuration')->with('message', 'Cleared Data');
    }
}
