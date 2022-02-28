<?php

namespace App\Http\Controllers;

use App\Models\AccessMaster;
use App\Models\LineMaster;
use App\Models\LoginMaster;
use App\Models\PlantMaster;
use Illuminate\Http\Request;
use App\Models\RoleMaster;
use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{

    function __construct() {
        // TODO restrict controller access for non admin roles
    }

    public function index()
    {
        $roles = RoleMaster::all();
        return view('access.list',compact('roles'));
    }

    public function manage()
    {
        $roles = RoleMaster::all();
        $plants = PlantMaster::all();
        $lines = LineMaster::all();
        
        return view('access.manage',compact('roles','plants','lines'));
    }

    public function view_access($role)
    {
        $accesses = DB::select("select 
        pm.plant_name,
        pm.plant_id,
        lm.line_id,
        lm.line_name,
        am.access_id
        from access_master as am 
        join plant_masters as pm on pm.plant_id = am.plant
        join line_masters as lm on lm.line_id = am.line
        where role = '{$role}'");

        return view('access.access',compact('accesses'));
    }

    public function create_access(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'role_id' => 'required',
            'plant_id' => 'required',
            'line_id' => 'required'
        ]);

        AccessMaster::create([
            'role' => $request->role_id,
            'plant' => $request->plant_id,
            'line' => $request->line_id
        ]);
        
        return redirect()->route('access.list')->with('message','Access Created');
    }

    public function role()
    {
        return view('access.role');
    }

    public function create_role(Request $request)
    {
        $request->validate([
            'role' => 'required'
        ]);

        if($request->role == 'admin')
        {
            return redirect()->route('access.role')->with('error','that name is not allowed');
        }
        
        RoleMaster::create([
            'name' => $request->role
        ]);

        return redirect()->route('access.list')->with('message','Role Created');
    }


}
