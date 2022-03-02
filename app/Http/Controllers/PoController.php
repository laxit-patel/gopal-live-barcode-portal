<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoController extends Controller
{
    private function getToken()
    {
        $token = "";
        return $token;
    }


    public function pushPO(Request $request)
    {
        $token =  $this->sapHeader();
        $curl = curl_init();

        $POData = DB::select('select 
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
        join product_masters as prm on prm.product_id = ppm.product_id ');

        
        foreach ($POData as $key => $item) {

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZCHECKWARE_UPDATE_1_SRV/Zcheckware_1Set?$format=json?sap-client=300',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "Mandt": "'. $request->query('mandt') .'",
                    "DataRead": "X",
                    "Narration": "",
                    "ProcessType": "System Data"
                    "ProductionVouNo": "'. $item->ProductionVouNo .'",
                    "BarcodeNumber": "'. $item->BarcodeNumber .'",
                    "VoucherDate": "'. $item->VoucherDate .'",
                    "Plant": "'. $item->Plant .'",
                    "BarcodeReader": "'. $item->BarcodeReader .'",
                    "ProductCode": "'. $item->ProductCode .'",
                    "ProductName": "'. $item->ProductName .'",
                    "Quantity1": "'. $item->Quantity1 .'",
                    "Unit1": "'. $item->Unit1 .'",
                }',
                CURLOPT_HTTPHEADER => array(
                    'x-csrf-token:' . $token['x-csrf-token'],
                    'Authorization: Basic UFdDQUJBUDphc2FwNEAxODA5',
                    'Content-Type: application/json',
                    'Cookie:' . $token['set-cookie'] . ';path=/ ; sap-usercontext=sap-client=120;'
                ),
            ));
        }

        $response = curl_exec($curl);
        curl_close($curl);
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
}
