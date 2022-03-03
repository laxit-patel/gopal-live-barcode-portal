<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PackingProductionMaster;
use App\Models\OrderMaster;
use App\Models\DispatchMaster;

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
        
        if($POData)
        {
            foreach ($POData as $key => $item) {
                $timestamp = date('Y-m-d h:i:sa');
                $vdate = date("Y-m-d",strtotime($item->VoucherDate));
                $data = '{
                    "Mandt": "300",
                    "ProductionVouNo": "'. $item->ProductionVouNo .'",
                    "BarcodeNumber": "'. $item->BarcodeNumber .'",
                    "VoucherDate": "'.$vdate.'T02:23:00",
                    "Plant": "GJ01",
                    "BarcodeReader": "CHECKWARE1",
                    "ProductCode": "'. $item->ProductCode .'",
                    "ProductName": "'. $item->ProductName .'",
                    "Quantity1": "'. $item->Quantity1 .'",
                    "Unit1": "'. $item->Unit1 .'",
                    "DataRead": "",
                    "Narration": "'.$timestamp.'",
                    "ProcessType": "API data"
                }';
                curl_setopt_array($curl, array(
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

                PackingProductionMaster::where('packing_production_id',$item->packing_production_id)->update(['status' => 1]);
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
        $itemData = [];
        $order_no = $request->query('order');
        $order = DB::select("select * from order_masters where so_po_no = '".$order_no."' LIMIT 1 ");

        $dataArr = [];
        $orderItems = [];
        if($order){
            $orderItems['SO_PO_NO'] = $order[0]->so_po_no;
            $tempItems = [];
            $items = DispatchMaster::select([
                'item_no as ITEM_NO',
                'product_id as ITEM_CODE',
                'qty as ORD_QTY',
                'unit',
                'qty as ORD_QTY',
                'dispatch_masters.so_po_no as order_no'
            ])->leftjoin('plant_masters','plant_masters.plant_id','dispatch_masters.plant_id')
            ->leftjoin('order_masters','order_masters.so_po_no','dispatch_masters.so_po_no')
            ->where('dispatch_masters.so_po_no',$order[0]->so_po_no)
            ->where('status','0')->get();

            foreach($items as $key => $item)
            {
                $orderItems['soheadertoitem'][$key]['SO_PO_NO'] = "$item->order_no";
                $orderItems['soheadertoitem'][$key]['ITEM_NO'] = "$item->ITEM_NO";
                $orderItems['soheadertoitem'][$key]['ITEM_CODE'] = "$item->ITEM_CODE";
                $orderItems['soheadertoitem'][$key]['ORD_QTY'] = "$item->ORD_QTY";
                $orderItems['soheadertoitem'][$key]['UOM'] = "$item->unit";
                $orderItems['soheadertoitem'][$key]['PLANT_CODE'] = $order[0]->plant;
            }
        
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
            $array = json_decode($json,TRUE);
            
            if(@$array['innererror']){
                //error
                return redirect()->back()->with('error','Push Error');
            }
            else{
                //success
                DispatchMaster::where('so_po_no',$order_no)->update([
                    'status' => 1
                ]);
                return redirect()->back()->with('success','Line Item Data Pushed');
            }

            
        }
        else{
            return redirect()->back()->with('error','Data not found.');
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
