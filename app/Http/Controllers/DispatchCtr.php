<?php

namespace App\Http\Controllers;

use App\Models\DispatchMaster;
use App\Models\LineMaster;
use App\Models\OrderMaster;
use App\Models\PlantMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispatchCtr extends Controller
{

    public function list()
    {
        $lineData = LineMaster::orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        $plantData = PlantMaster::join('barcode_machine_masters','barcode_machine_masters.plant_id','plant_masters.plant_id')->get();
        $dispatchData = OrderMaster::leftJoin('plant_masters','order_masters.plant','plant_masters.plant_name')->get();
        return view('dispatch.list', compact('dispatchData', 'lineData','plantData'));
    }

    public function update(Request $request)
    {
        foreach ($request->line_id as $dispatch_id => $line_id) {
            DispatchMaster::where('dispatch_id', $dispatch_id)->update(['line_id' => $line_id]);
        }
        return redirect()->route('dispatch');
    }

    public function getLineItems($order)
    {
        $OrderDetails = OrderMaster::leftJoin("customer_master","customer_master.customer_id","order_masters.customer_id")
        ->select(
        'order_masters.plant as plant',
        'order_masters.so_po_no',
        'order_masters.po_no',
        'order_masters.plant',
        'order_masters.line_no',
        'order_masters.sales_org',
        'order_masters.dist_chan',
        'order_masters.total',
        )
        ->where('so_po_no',$order)->first();

        $line_id = $OrderDetails->line_no;
        $plant_code = $OrderDetails->plant;
        
        $lineItems = DB::select("select dm.*, pm.plant_name, lm.line_name, (dm.qty - count(dm.barcode)) as pending, pms.description from dispatch_masters as dm join plant_masters as pm on pm.plant_id = dm.plant_id
        join order_masters as om on om.so_po_no = dm.so_po_no
        left join line_masters as lm on lm.plant_id = pm.plant_id
        join product_masters as pms on pms.material_code = dm.product_id
        left join raw_dispatch_masters as rd on rd.barcode = dm.barcode
        where pm.plant_name = '{$plant_code}' and dm.line_id = '{$line_id}' group by dm.barcode");

        
        return view('dispatch.items',compact('lineItems','OrderDetails'));
    }

    public function updateLine(Request $request)
    {
        $request->validate([
            'so_po_no' => 'required',
            'plant_id' => 'required',
            'line_id' => 'required'
        ]);

        $plant = explode('|',$request->plant_id);

        OrderMaster::where('so_po_no', $request->so_po_no)->update([
            'line_no' => $request->line_id,
            'plant' => $plant[1]
        ]);

        DispatchMaster::where('so_po_no', $request->so_po_no)->update([
            'line_id' => $request->line_id,
            'plant_id' => $plant[0]
        ]);
        return redirect()->route('dispatch');
    }

    public function getPendingItems($plant_no,$line_no,$po)
    {

        // $pending = DB::select("select dm.*, dm.product_id as mat_code, (dm.qty - count(rd.barcode)) as pending from dispatch_masters as dm 
        // join plant_masters as pm on pm.plant_id = dm.plant_id 
        // left join raw_dispatch_masters as rd on rd.barcode = dm.barcode
        // where dm.so_po_no = '{$po}' 
        // and pm.plant_name = '{$plant_no}' 
        // and dm.line_id = '{$line_no}'
        // group by dm.barcode");

        $pending = DB::select("select dm.*, 
        pm.plant_name, 
        lm.line_name, 
        (dm.qty - count(rd.barcode)) as pending, 
        pms.description 
        from dispatch_masters as dm join plant_masters as pm on pm.plant_id = dm.plant_id
        join order_masters as om on om.so_po_no = dm.so_po_no
        left join line_masters as lm on lm.plant_id = pm.plant_id
        join product_masters as pms on pms.material_code = dm.product_id
        left join raw_dispatch_masters as rd on rd.barcode = dm.barcode
        where pm.plant_name = '{$plant_no}' and dm.line_id = '{$line_no}' group by dm.barcode");
        

        $tr = '';
        foreach ($pending as $key => $row) {
            $key++;
            $tr .= "<tr class=' '>
            <td class='text-center' >{$key}</td>
            <td class='text-left '>{$row->product_id}</td>
            <td class='text-left '>{$row->description}</td>
            <td class='text-left '>{$row->barcode}</td>
            <td class='text-left '>{$row->sales_voucher}</td>
            <td class='text-center '>{$row->qty}</td>
            <td class='text-center '>{$row->pending}</td>
            </tr>";
        }
        
        return response()->json($tr);
        
        return true;
    }
}
