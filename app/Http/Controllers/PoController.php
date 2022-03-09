<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PackingProductionMaster;
use App\Models\OrderMaster;
use App\Models\DispatchMaster;
use App\Models\RawDispatchMaster;
use App\Models\PlantMaster;
use App\Models\LineMaster;

class PoController extends Controller
{
    private function getToken()
    {
        $token = "";
        return $token;
    }

    public function pushPO()
    {
        $token =  $this->sapHeader();
        $curl = curl_init();

        $POData = DB::select('select 
        packing_production_id,
        production_voucher as ProductionVouNo,
        ppm.barcode as BarcodeNumber,
        ppm.created_at as VoucherDate,
        plant_name as Plant,
        line_name as BarcodeReader,
        material_code as ProductCode,
        description as ProductName,
        ppm.qty as Quantity1,
        prm.uom as Unit1
        from packing_production_masters as ppm
        join plant_masters as pm on pm.plant_id =  ppm.plant_id 
        join line_masters as lm on lm.line_id =  ppm.line_id
        join product_masters as prm on prm.barcode = ppm.barcode 
        where ppm.status = 0');

        //dd($POData);
        if ($POData) {
            foreach ($POData as $key => $item) {
                $timestamp = date('Y-m-d h:i:sa');
                $vdate = date("Y-m-d", strtotime($item->VoucherDate));
                $data = '{
                    "Mandt": "300",
                    "ProductionVouNo": "' . $item->ProductionVouNo . '",
                    "BarcodeNumber": "' . $item->BarcodeNumber . '",
                    "VoucherDate": "' . $vdate . 'T02:23:00",
                    "Plant": "' . $item->Plant . '",
                    "BarcodeReader": "' . $item->BarcodeReader . '",
                    "ProductCode": "' . $item->ProductCode . '",
                    "ProductName": "' . $item->ProductName . '",
                    "Quantity1": "' . $item->Quantity1 . '",
                    "Unit1": "' . $item->Unit1 . '",
                    "DataRead": "",
                    "Narration": "' . $timestamp . '",
                    "ProcessType": "API data"
                }';
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZCHECKWARE_UPDATE_1_SRV/Zcheckware_1Set',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $data,
                        CURLOPT_HTTPHEADER => array(
                            'x-csrf-token:' . $token['x-csrf-token'],
                            'Authorization: Basic QkFSQ09ERTAxOkdvcGFsQDEyMzQ1',
                            'Content-Type: application/json',
                            'Cookie:' . $token['set-cookie'] . ';path=/ ; sap-usercontext=sap-client=300;'
                        ),
                    )
                );

                PackingProductionMaster::where('packing_production_id', $item->packing_production_id)->update(['status' => 1]);
                $response = curl_exec($curl);
                curl_close($curl);
            }

            //echo '<pre>';print_r($response);exit;
        }
        return true;
    }

    public function sapHeader()
    {
        $curl = curl_init();
        $headers = [];
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZCHECKWARE_UPDATE_1_SRV/Zcheckware_1Set?$format=json?sap-client=300',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-csrf-token: Fetch',
                // 'Connection: keep-alive',
                'Authorization: Basic QkFSQ09ERTAxOkdvcGFsQDEyMzQ1',
                'Cookie: sap-usercontext=sap-client=300'
            ),
        ));
        curl_setopt(
            $curl,
            CURLOPT_HEADERFUNCTION,
            function ($curl2, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))] = trim($header[1]);
                return $len;
            }
        );

        curl_exec($curl);
        return $headers;
    }

    // Dispatch API 
    public function pushLineItems(Request $request)
    {
        $curl = curl_init();

        $order_no = $request->query('order');
        $plant = $request->query('plant');
        $line = $request->query('line');

        $order = DB::select("select * from order_masters where so_po_no = '" . $order_no . "' LIMIT 1 ");

        $orderItems = [];
        if ($order) {
            $so_po_no = $order[0]->so_po_no;
            $orderItems['SO_PO_NO'] = $so_po_no;
            $items = DB::select("select dm.*, 
                pm.plant_name, 
                lm.line_name,
                pm.plant_id,
                pms.description ,
                pms.barcode,
                count(rd.barcode) as countQty
                from dispatch_masters as dm 
                join plant_masters as pm on pm.plant_id = dm.plant_id
                join order_masters as om on om.so_po_no = dm.so_po_no
                left join line_masters as lm on lm.line_id = dm.line_id
                left join product_masters as pms on pms.material_code = dm.product_id
                left join raw_dispatch_masters as rd on (rd.barcode = pms.barcode and (rd.status IS null or rd.status = 0))
                where pm.plant_name = '{$plant}'
                and dm.line_id = '{$line}'
                and dm.sales_voucher='{$so_po_no}'
                group by dm.barcode, dm.product_id;");

            $pending = DB::select("select 
                rdm.*,
                pm.uom,
                pl.plant_name, 
                pl.plant_id,
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
                where pl.plant_name = '{$plant}'
                and (rdm.status IS null or rdm.status = 0)
                and rdm.barcode not IN (select barcode from dispatch_masters where sales_voucher = '{$so_po_no}')
                and rdm.`line_id` = '{$line}'
                group by rdm.barcode, rdm.product_id;");

            $having = '';
            $i = 0;
            foreach ($items as $item) {
                if ($item->product_id) {
                    $orderItems['soheadertoitem'][$i]['SO_PO_NO'] = "$so_po_no";
                    $orderItems['soheadertoitem'][$i]['ITEM_NO'] = "$item->item_no";
                    $orderItems['soheadertoitem'][$i]['ITEM_CODE'] = "$item->product_id";
                    $orderItems['soheadertoitem'][$i]['ORD_QTY'] = "$item->countQty";
                    $orderItems['soheadertoitem'][$i]['UOM'] = "$item->unit";
                    $orderItems['soheadertoitem'][$i]['PLANT_CODE'] = $order[0]->plant;
                    $having .= $item->barcode . ',';
                    $dis = DispatchMaster::where('product_id', $item->product_id)->update(['read_qty' => $item->countQty]);
                    $i++;
                }
            }
            $plant_id = $items[0]->plant_id;
            if ($pending) {

                foreach ($pending as $item) {
                    if ($item->material_code) {
                        $orderItems['soheadertoitem'][$i]['SO_PO_NO'] = "$so_po_no";
                        $orderItems['soheadertoitem'][$i]['ITEM_NO'] = "";
                        $orderItems['soheadertoitem'][$i]['ITEM_CODE'] = "$item->material_code";
                        $orderItems['soheadertoitem'][$i]['ORD_QTY'] = "$item->countQty";
                        $orderItems['soheadertoitem'][$i]['UOM'] = "$item->uom";
                        $orderItems['soheadertoitem'][$i]['PLANT_CODE'] = $order[0]->plant;
                        $having .= $item->barcode . ',';
// echo '<pre>';print_r($orderItems);exit;
                        //insert into dispatch master table
                        $dispatch = new DispatchMaster;
                        $dispatch->sales_voucher = $so_po_no;
                        $dispatch->plant_id = $plant_id;
                        $dispatch->line_id = $line;
                        $dispatch->barcode = $item->barcode;
                        $dispatch->product_id = $item->material_code;
                        $dispatch->qty = $item->countQty;
                        $dispatch->read_qty = $item->countQty;
                        $dispatch->unit = $item->uom;
                        $dispatch->so_po_no = $so_po_no;
                        $dispatch->item_no = DispatchMaster::where('sales_voucher', $so_po_no)->max('item_no');
                        $dispatch->status = 0;
                        $dispatch->save();


                        $i++;
                    }
                    //update raw dispatch table

                }
            }

            // $pending = RawDispatchMaster::whereIn('barcode', [ltrim(rtrim($having, ","),",")])->where('line_id', $line)->where('plant_id', $plant_id)->whereNull('status')->orWhere('status',0)->update(['status' => 1]);
            $pending = RawDispatchMaster::where('line_id', $line)->where('plant_id', $plant_id)->whereNull('status')->orWhere('status', 0)->update(['status' => 1]);

            $data = json_encode($orderItems);
            //echo '<pre>';print_r($data);exit;
            $token =  $this->sapHeader2();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZTRUCK_LOAD_SRV/SOHEADERSet?sap-client=300',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    'x-csrf-token:' . $token['x-csrf-token'],
                    'Authorization: Basic QkFSQ09ERTAxOkdvcGFsQDEyMzQ1',
                    'Content-Type: application/json',
                    'Cookie:' . $token['set-cookie'] . ';path=/ ; sap-usercontext=sap-client=300;'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $xml = \simplexml_load_string($response);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            if (@$array['innererror']) {
                //error
                OrderMaster::where('so_po_no', $order_no)->update(['sap_log' => $array, "sap_json" => $data]);
                return redirect()->back()->with('error', 'Push Error');
            } else {
                //success
                DispatchMaster::where('so_po_no', $order_no)->update(['status' => 1]);
                OrderMaster::where('so_po_no', $order_no)->update([
                    'status' => 1, 'sap_log' => $array, "sap_json" => $data
                ]);
                LineMaster::where('line_id', $line)->update([
                    'occupied' => 0
                ]); // occuoy line master

                PlantMaster::where('plant_name', $plant)->update([
                    'occupied' => 0
                ]); // occupy plant master

                // echo '<pre>';print_r($data);exit;
                return redirect()->back()->with('success', 'Line Item Data Pushed');
            }
        } else {
            return redirect()->back()->with('error', 'Data not found.');
        }
    }

    public function sapHeader2()
    {
        $curl = curl_init();
        $headers = [];
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZTRUCK_LOAD_SRV/SOHEADERSet?$expand=soheadertoitem&$format=json?sap-client=300',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-csrf-token: Fetch',
                // 'Connection: keep-alive',
                'Authorization: Basic QkFSQ09ERTAxOkdvcGFsQDEyMzQ1',
                'Cookie: sap-usercontext=sap-client=300'
            ),
        ));
        curl_setopt(
            $curl,
            CURLOPT_HEADERFUNCTION,
            function ($curl2, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))] = trim($header[1]);
                return $len;
            }
        );

        curl_exec($curl);

        return $headers;
    }
}
