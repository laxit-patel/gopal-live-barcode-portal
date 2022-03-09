<?php

namespace App\Http\Controllers;

use App\Models\DispatchMaster;
use App\Models\LineMaster;
use App\Models\OrderMaster;
use App\Models\PlantMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispatchCtr extends Controller
{

    public function list()
    {
        $lineData = LineMaster::where('occupied',0)->orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        $plantData = PlantMaster::where('occupied',0)->get(); //NEW code
        // $plantData = PlantMaster::where('occupied',0)->join('barcode_machine_masters', 'barcode_machine_masters.plant_id', 'plant_masters.plant_id')->orderBy('plant_masters.plant_name')->get(); //old code
        $dispatchData = OrderMaster::leftJoin('plant_masters', 'order_masters.plant', 'plant_masters.plant_name')->get();
        return view('dispatch.list', compact('dispatchData', 'lineData', 'plantData'));
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
        $OrderDetails = OrderMaster::leftJoin("customer_master", "customer_master.customer_id", "order_masters.customer_id")
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
            ->where('so_po_no', $order)->first();

        $line_id = $OrderDetails->line_no;
        $plant_code = $OrderDetails->plant;
        $order_status = @$OrderDetails->status;

        $nagative = '';
        if ($line_id) {
            if ($order_status == 1) {
                // echo 1 ;exit;
                $q = 'and rd.status = 1';
                $n = "and rdm.status = 1";
            } else {
                // echo 2;exit;
                $q = 'and (rd.status IS null or rd.status = 0)';
                $n = "and (rdm.status IS null or rdm.status = 0)";
            }
            // $q = $n = '';
            $lineItems = DB::select("select dm.*, 
                pm.plant_name, 
                lm.line_name, 
                (dm.qty - count(rd.barcode)) as pending, 
                pms.description ,
                count(rd.barcode) as countQty
                from dispatch_masters as dm 
                join plant_masters as pm on pm.plant_id = dm.plant_id
                join order_masters as om on om.so_po_no = dm.so_po_no
                left join line_masters as lm on lm.line_id = dm.line_id
                left join product_masters as pms on pms.material_code = dm.product_id
                left join raw_dispatch_masters as rd on (rd.barcode = dm.barcode {$q})
                where pm.plant_name = '{$plant_code}'
                and dm.line_id = '{$line_id}'
                
                and dm.sales_voucher='{$OrderDetails->so_po_no}'
                group by dm.barcode, dm.product_id;");

            if (@$order_status) {

                $nagative = DB::select("select 
                rdm.*,
                pm.material_code,
                pl.plant_name, 
                lm.line_name, 
                0 as pending, 
                pm.description, 
                count(rdm.barcode) as countQty,
                0 as qty
                from `raw_dispatch_masters` as rdm 
                join plant_masters as pl on pl.plant_id = rdm.plant_id 
                join line_masters as lm on lm.line_id = rdm.line_id 
                left join `product_masters` as pm on pm.barcode = `rdm`.`barcode`
                where pl.plant_name = '{$plant_code}'
                {$n}
                and rdm.barcode not IN (select barcode from dispatch_masters where sales_voucher = '{$OrderDetails->so_po_no}')
                and rdm.`line_id` = '{$line_id}'
                group by rdm.barcode, rdm.product_id;");
            }
        } else {
            $lineItems = DB::select("select dm.*, 
            pm.plant_name,
            (dm.qty - count(rd.barcode)) as pending, 
            pms.description ,
            count(rd.barcode) as countQty
            from dispatch_masters as dm 
            join plant_masters as pm on pm.plant_id = dm.plant_id
            join order_masters as om on om.so_po_no = dm.so_po_no
            left join product_masters as pms on pms.material_code = dm.product_id
            left join raw_dispatch_masters as rd on rd.barcode = dm.barcode
            where pm.plant_name = '{$plant_code}'
            and dm.sales_voucher='{$OrderDetails->so_po_no}'
            group by dm.barcode, dm.product_id;");
        }

        $pendingLineItems = DispatchMaster::where('so_po_no', $OrderDetails->so_po_no)->where('status', '0')->count();

        return view('dispatch.items', compact('lineItems', 'OrderDetails', 'nagative', 'pendingLineItems'));
    }

    public function updateLine(Request $request)
    {
        $request->validate([
            'so_po_no' => 'required',
            'plant_id' => 'required',
            'line_id' => 'required'
        ]);

        $plant = explode('|', $request->plant_id);

        LineMaster::where('line_id',$request->line_id)->update([
            'occupied' => 1
        ]); // occuoy line master

        PlantMaster::where('plant_name',$plant[1])->update([
            'occupied' => 1
        ]); // occupy plant master

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

    public function getPendingItems($plant_no, $line_no, $po)
    {
        $OrderDetails = OrderMaster::where('so_po_no', $po)->first();
        $nagative = '';
        if ($line_no) {
            $order_status = @$OrderDetails->status;

            if ($order_status == 1) {
                // echo 1 ;exit;
                $q = 'and rd.status = 1';
                $n = "and rdm.status = 1";
            } else {
                // echo 2;exit;
                $q = 'and (rd.status IS null or rd.status = 0)';
                $n = "and (rdm.status IS null or rdm.status = 0)";
            }
            $pending = DB::select("select dm.*, 
            pm.plant_name, 
            lm.line_name, 
            (dm.qty - count(rd.barcode)) as pending, 
            pms.description ,
            count(rd.barcode) as countQty
            from dispatch_masters as dm 
            join plant_masters as pm on pm.plant_id = dm.plant_id
            join order_masters as om on om.so_po_no = dm.so_po_no
            left join line_masters as lm on lm.line_id = dm.line_id
            left join product_masters as pms on pms.material_code = dm.product_id
            left join raw_dispatch_masters as rd on (rd.barcode = dm.barcode {$q})
            where pm.plant_name = '{$plant_no}'
            and dm.line_id = '{$line_no}'
            and dm.sales_voucher='{$po}'
            group by dm.barcode, dm.product_id;");
            // echo '<pre>';print_r($pending);exit;
            if (@$pending[0]->status != 1) {
                $nagative = DB::select("select 
                rdm.*,
                pl.plant_name, 
                lm.line_name,
                pm.material_code,
                0 as pending, 
                pm.description, 
                count(rdm.barcode) as countQty,
                0 as qty
                from `raw_dispatch_masters` as rdm 
                join plant_masters as pl on pl.plant_id = rdm.plant_id 
                join line_masters as lm on lm.line_id = rdm.line_id 
                left join `product_masters` as pm on pm.barcode = `rdm`.`barcode` 
                where pl.plant_name = '{$plant_no}'
                {$n}
                and rdm.barcode not IN (select barcode from dispatch_masters where sales_voucher = '{$po}')
                and rdm.`line_id` = '{$line_no}'
                group by rdm.barcode, rdm.product_id;");
            }
        } else {
            $pending = DB::select("select dm.*, 
            pm.plant_name, 
            lm.line_name, 
            (dm.qty - count(rd.barcode)) as pending, 
            pms.description ,
            count(rd.barcode) as countQty
            from dispatch_masters as dm 
            join plant_masters as pm on pm.plant_id = dm.plant_id
            join order_masters as om on om.so_po_no = dm.so_po_no
            left join product_masters as pms on pms.material_code = dm.product_id
            left join raw_dispatch_masters as rd on rd.barcode = dm.barcode
            where pm.plant_name = '{$plant_no}'
            and dm.sales_voucher='{$po}'
            group by dm.barcode, dm.product_id;");
        }

        $tr = '';
        foreach ($pending as $key => $row) {
            $key++;
            $tr .= "<tr class=' '>
            <td class='text-left '>{$row->product_id}</td>
            <td class='text-left '>{$row->description}</td>
            <td class='text-left '>{$row->barcode}</td>
            <td class='text-left '>{$row->sales_voucher}</td>
            <td class='text-center '>{$row->qty}</td>
            <td class='text-center '>{$row->countQty}</td>
            <td class='text-center '>{$row->pending}</td>
            </tr>";
        }
        if ($nagative) {
            foreach ($nagative as $key => $row) {
                $tr .=
                    "<tr class='bg-light-danger '>
            
            <td class=''>{$row->material_code}</td>
            <td class='text-left '>{$row->description}</td>
            <td class='text-left '>{$row->barcode}</td>
            <td class='text-left '></td>
            <td class='text-center '>{$row->qty}</td>
            <td class='text-center '>{$row->countQty}</td>
            <td class='text-center '>{$row->pending}</td>
            </tr>";
            }
        }

        return response()->json($tr);

        return true;
    }
}
