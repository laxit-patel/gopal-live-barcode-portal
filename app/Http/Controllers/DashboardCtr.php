<?php

namespace App\Http\Controllers;

use App\Models\AccessMaster;
use App\Models\BarcodeMachineMaster;
use App\Models\DispatchMaster;
use App\Models\LineMaster;
use App\Models\OrderMaster;
use App\Models\PackingProductionMaster;
use App\Models\PlantMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use App\Models\RawPackingMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardCtr extends Controller
{

    public function dashboard()
    {
        return view('dashboard');
    }

    public function listdata(Request $request)
    {

        $ajax = ($request->ajax) ? $request->ajax : 0;
        $no = ($request->no) ? $request->no : 0;
        $plant_id = $request->plant_id;
        $line_id = $request->line_id;
        $pageType = null;
        $productData = [];
        $display_type = null;
        $customer = null;
        $pending = null;

        // $line_id = '2';
        // $plant_id = '2';

        if (!empty($plant_id) && !empty($line_id)) {

            $this->access($plant_id,$line_id); //check if user has access

            $machineData = BarcodeMachineMaster::where('plant_id', $plant_id)->where('line_id', $line_id)->first('type');

            $pageType = $machineData->type;
            $display_type = $machineData->type;
            if ($machineData->type == 'dispatch') {
                $order_master = OrderMaster::join("plant_masters as pm", "pm.plant_name", "order_masters.plant")->
                where('pm.plant_id', $plant_id)->where('line_no', $line_id)->where('status',0)->first();
                $order = @$order_master->so_po_no;
                $productData = DB::select("select dm.*, 
                pm.plant_name, 
                lm.line_name, 
                (dm.qty - count(rd.barcode)) as pending, 
                pms.description ,
                rdm.created_at as dt,
                count(rd.barcode) as countQty
                from dispatch_masters as dm 
                join plant_masters as pm on pm.plant_id = dm.plant_id
                join order_masters as om on om.so_po_no = dm.so_po_no
                left join line_masters as lm on lm.line_id = dm.line_id
                left join product_masters as pms on pms.material_code = dm.product_id
                left join raw_dispatch_masters as rd on (rd.barcode = dm.barcode and (rd.status = 0 or rd.status is null))
                where pm.plant_id = '{$plant_id}'
                and dm.line_id = '{$line_id}'
                and dm.so_po_no = '{$order}'
                group by dm.barcode, dm.product_id order by dt DESC;");
               

                if ($productData) {
                    $pending = DB::select("select 
                        rdm.*,
                        pm.material_code,
                        pl.plant_name, 
                        lm.line_name, 
                        0 as pending, 
                        pm.description,
                        rdm.created_at as dt,
                        count(rdm.barcode) as countQty,
                        0 as qty
                        from `raw_dispatch_masters` as rdm 
                        join plant_masters as pl on pl.plant_id = rdm.plant_id 
                        join line_masters as lm on lm.line_id = rdm.line_id 
                        left join `product_masters` as pm on pm.barcode = `rdm`.`barcode`
                        where pl.plant_id = '{$plant_id}'
                        and (rdm.status = 0 or rdm.status is null)
                        and rdm.barcode not IN (select barcode from dispatch_masters where sales_voucher = '{$order}')
                        and rdm.`line_id` = '{$line_id}'
                        group by rdm.barcode, rdm.product_id order by dt DESC;");
                }
                $customer = DB::select("select * from order_masters as om 
                join customer_master as cm 
                on cm.customer_number = om.sold_to
                where om.so_po_no = '{$order}'");
                // dd($customer);

            } elseif ($machineData->type == 'packing') {

                DB::enableQueryLog();
                $productData = RawPackingMaster::join('product_masters', 'raw_packing_masters.barcode', 'product_masters.barcode')
                    ->where('raw_packing_masters.plant_id',  $plant_id)
                    ->where('raw_packing_masters.line_id',  $line_id)
                    ->groupBy('raw_packing_masters.barcode')
                    ->orderby('dt', 'DESC')
                    ->get(['product_masters.*', DB::raw('count(*) as countQty, MAX(raw_packing_masters.created_at) as dt')]);

                // dd(DB::getQueryLog());
            }

            // dd($productData);
            if ($ajax) {

                if ($machineData->type == 'packing') {

                    $tr = '';
                    $th = "<thead>
                        <tr class='bg-light-primary fs-2 text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0'>
                            <th class='text-center'>Product Code</th>
                            <th >Product Name</th>
                            <th >Barcode</th>
                            <th class='text-center '>No. Of Boxes</th>
                        </tr>
                        </thead>";

                    $i = 0;
                    foreach ($productData as $key => $row) {
                        $new = ($i == 0) ? 'bg-light-warning' : '';
                        $tr .= "<tr class='fs-2 text-gray-700 fw-bold {$new}'>
                            <td class='text-center '>{$row->material_code}</td>
                            <td>{$row->description}</td>
                            <td>{$row->barcode}</td>
                            <td class='text-center fw-boldest fs-2'>{$row->countQty}</td>
                            </tr>";
                        $i++;
                    }


                    return response()->json($th . $tr);
                } elseif ($machineData->type == 'dispatch') {

                    $customer_number = @$customer[0]->customer_number;
                    $customer_name = @$customer[0]->name;

                    $tr = '';
                    $th = "<thead >
                        <tr class='bg-light-primary fs-2 text-start text-gray-800 fw-bolder fs-7 text-uppercase gs-0'>
                        <td class='text-end'>Customer Name</td>
                        <td colspan='' >{$customer_name}</td>
                        <td></td>
                        <td></td>
                        <td class='text-end'>Customer Number</td>
                        <td colspan='' >{$customer_number}</td>
                        </tr>
                        <tr class='bg-light-primary fs-2 text-start text-gray-500 fw-bolder fs-7 text-uppercase gs-0'>
                            <th class='text-center'>Product Code</th>
                            <th >Product Name</th>
                            <th >Barcode</th>
                            <th class='text-center '>SO. Qty</th>
                            <th class='text-center '>Qty</th>
                            <th class='text-center '>Pending</th>
                        </tr>
                        </thead>";


                    foreach ($productData as $key => $row) {
                        $tr .= "<tr class='fs-2 text-gray-700 fw-bold '>
                        <td class='text-center '>{$row->product_id}</td>
                        <td>{$row->description}</td>
                        <td>{$row->barcode}</td>
                        <td class='text-center fw-boldest fs-2'>{$row->qty}</td>
                        <td class='text-center fw-boldest fs-2'>{$row->countQty}</td>
                        <td class='text-center fw-boldest fs-2'>{$row->pending}</td>
                        </tr>";
                    }

                    if ($pending) {
                        foreach ($pending as $key => $row) {

                            $tr .= "<tr class='fs-2 text-gray-700 fw-bold bg-light-warning'>
                            <td class='text-center '>{$row->material_code}</td>
                            <td>{$row->description}</td>
                            <td>{$row->barcode}</td>
                            <td class='text-center fw-boldest fs-2'>{$row->qty}</td>
                            <td class='text-center fw-boldest fs-2'>{$row->countQty}</td>
                            <td class='text-center fw-boldest fs-2'>{$row->pending}</td>
                            </tr>";
                        }
                    }

                    return response()->json($th . $tr);
                }
            }
            $display_choice = false;
        } else {
            $display_choice = true;
        }
        // return $productData;
        $plantData = PlantMaster::orderby('plant_name')->get(['plant_id', 'plant_name']);
        $lineData = LineMaster::orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        return view('rawDataList', compact('productData', 'plantData', 'lineData', 'pageType', 'display_choice', 'display_type', 'customer', 'pending'));
    }


    /*************** Create API Funcitons ***************** */

    function getProductionReport()
    {
        $productionVoucherData = PackingProductionMaster::where('status', '0')->orderby('production_voucher', 'DESC')->first('production_voucher');
        $data = PackingProductionMaster::join('product_masters', 'product_masters.product_id', 'packing_production_masters.product_id')
            ->where('packing_production_masters.status', '0')
            ->where('packing_production_masters.production_voucher', $productionVoucherData->production_voucher)
            // ->orderby('packing_production_masters.production_voucher')
            ->orderby('packing_production_masters.packing_production_id')
            ->get();
        foreach ($data as $row) {
            $content[] = [
                'SO_NO' => $row->packing_production_id,
                'ITEM_NO' => $row->product_id,
                'ITEM_CODE' => $row->material_code,
                'ORD_QTY' => $row->qty,
                'UOM' => $row->unit,
                'PLANT_CODE' => $row->plant_id
            ];
        }
        $header = [
            'Content-Type' => 'application/json',
            'SO_PO_NO' => '',
            'SOLD_TO' => '',
            'SALES_ORG' => '',
            'DIST_CHAN' => '',
            'PO_NO' => $data[0]->production_voucher,
            'PLANT' => $data[0]->plant_id,
            'TOTAL_AMT' => ''
        ];

        return response($content)
            ->withHeaders($header);
    }

    public function getDispatchSave(Request $request)
    {

        $SO_PO_NO = $request->SO_PO_NO;
        $ITEM_NO = $request->ITEM_NO;
        $ITEM_CODE = $request->ITEM_CODE;
        $DISP_QTY = $request->DISP_QTY;
        $UOM = $request->UOM;
        $PLANT_CODE = $request->PLANT_CODE;
        $plant = PlantMaster::where('plant_name', $request->PLANT)->first();

        DB::transaction(function () use ($request, $plant) {

            OrderMaster::create([
                'so_po_no' => $request->SO_PO_NO,
                'sold_to' => $request->SOLD_TO,
                'sales_org' => $request->SALES_ORG,
                'dist_chan' => $request->DIST_CHAN,
                'po_no' => $request->PO_NO,
                'plant' => $request->PLANT,
                'total' => $request->TOTAL_AMT
            ]);

            if ($request->ITEM) {
                foreach ($request->ITEM as $items) {
                    //echo $plant->plant_id;exit;
                    DispatchMaster::create([
                        'so_po_no' => $request->SO_PO_NO,
                        'sales_voucher' => $items['SO_NO'],
                        'item_no' => $items['ITEM_NO'],
                        'plant_id' => \intval(@$plant->plant_id),
                        'product_id' => $items['ITEM_CODE'],
                        'qty' => $items['ORD_QTY'],
                        'unit' => $items['UOM'],
                        'barcode' => $items['BARCODE']
                    ]);
                }
            }
        });

        $content = [
            'success' => true,
            'message' => 'updated data'
        ];

        return response($content);
    }

    public function access($plant_id,$line_id)
    {
        $role = session()->get('loggedData')['role'];

            if($role != 'admin')
            {
                $access = AccessMaster::where('role',$role)
                ->where('plant',$plant_id)
                ->where('line',$line_id)
                ->count();
                
                if($access == 0 ){   abort(403); }
            }
    }
}
