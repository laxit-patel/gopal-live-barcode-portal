<?php

namespace App\Http\Controllers;

use App\Models\BarcodeMachineMaster;
use App\Models\DispatchMaster;
use App\Models\LineMaster;
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

    public function listdata($ajax = 0, $no = 0, Request $request)
    {
        $plant_id = $request->plant_id;
        $line_id = $request->line_id;
        $pageType = null;
        $productData = [];
        if (!empty($plant_id) && !empty($line_id)) {

            $machineData = BarcodeMachineMaster::where('plant_id', $plant_id)->where('line_id', $line_id)->first('type');

            $pageType = $machineData->type;
            if ($machineData->type == 'dispatch') {

                $productData = RawDispatchMaster::join('product_masters', 'raw_dispatch_masters.product_id', 'product_masters.product_id')
                ->where('raw_dispatch_masters.plant_id',  $plant_id)
                ->where('raw_dispatch_masters.line_id',  $line_id)
                ->groupBy('raw_dispatch_masters.barcode')
                ->orderby( 'dt', 'DESC')
                ->get(['product_masters.*',DB::raw('count(*) as countQty, MAX(raw_dispatch_masters.created_at) as dt')]);


            } elseif ($machineData->type == 'packing') {
                DB::enableQueryLog();
               $productData = RawPackingMaster::join('product_masters', 'raw_packing_masters.product_id','product_masters.product_id')
                ->where('raw_packing_masters.plant_id',  $plant_id)
                ->where('raw_packing_masters.line_id',  $line_id)
                ->groupBy('raw_packing_masters.barcode')
                ->orderby( 'dt', 'DESC')
                ->get(['product_masters.*',DB::raw('count(*) as countQty, MAX(raw_packing_masters.created_at) as dt')]);

            }
            if ($ajax) {
                
                $tr = '';
                foreach ($productData as $key => $row) {
                    $tr .= "<tr class='fs-2 text-gray-700 fw-bold '>
                    <td class='text-center '>{$row['material_code']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['barcode']}</td>
                    <td class='text-center fw-boldest fs-2'>{$row['countQty']}</td>
                    </tr>";
                    
                }
                return response()->json($tr);
            }
            $display_choice = false;
        }else
        {
            $display_choice = true;
        }
// return $productData;
        $plantData = PlantMaster::orderby('plant_name')->get(['plant_id', 'plant_name']);
        $lineData = LineMaster::orderby('line_name')->get(['line_id', 'plant_id', 'line_name']);
        return view('rawDataList', compact('productData', 'plantData', 'lineData', 'pageType','display_choice'));
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

        $productData = ProductMaster::where('material_code', $ITEM_CODE)->first(['product_id', 'barcode']);
        $data = new DispatchMaster;
        $data->sales_voucher = $SO_PO_NO;
        // $data->product_id = $ITEM_NO;
        $data->product_id = $productData->product_id;
        $data->qty = $DISP_QTY;
        $data->unit = $UOM;
        $data->barcode = $productData->barcode;
        $data->plant_id = $PLANT_CODE;
        $data->line_id = 0;
        $data->save();
        $content = [
            'success' => true,
            'message' => 'updated data'
        ];

        return response($content);
    }
    
}
