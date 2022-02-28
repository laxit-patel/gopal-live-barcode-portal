<?php

namespace App\Console\Commands;

use App\Models\PackingProductionMaster;
use App\Models\RawPackingMaster;
use Illuminate\Console\Command;

class ProductionVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Production:Voucher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = RawPackingMaster::where('status', '0')->get();
        $voucherNo = (PackingProductionMaster::max('production_voucher') + 1);
        foreach ($data as $key => $row) {
            if (empty($key)) {
                $packingData = new PackingProductionMaster;
            } else {
                $packingData = PackingProductionMaster::where('production_voucher', $voucherNo)
                    ->where('plant_id', $row->plant_id)
                    ->where('line_id', $row->line_id)
                    ->where('barcode', $row->barcode)
                    ->where('product_id', $row->product_id)
                    ->first();
                if (empty($packingData)) {
                    $packingData = new PackingProductionMaster;
                }
            }
            $packingData->production_voucher = $voucherNo;
            $packingData->plant_id = $row->plant_id;
            $packingData->line_id = $row->line_id;
            $packingData->barcode = $row->barcode;
            $packingData->product_id = $row->product_id;
            $packingData->qty = ($packingData->qty ? $packingData->qty : 0) + 1;
            $packingData->unit = 'box';
            $packingData->save();

            RawPackingMaster::where('status', '0')->where('raw_packing_id', $row->raw_packing_id)->update(['status' => '1']);
        }
        $this->info('Updated on packing production');

        $this->sapHeader();

    }


private function sapHeader()
    {
        $curl = curl_init();
        $headers = [];
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://gsdevapp:8000/sap/opu/odata/sap/ZCHECKWARE_UPDATE_1_SRV/Zcheckware_1Set?$format=json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '', 
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        'x-csrf-token: Fetch',
        'Connection: keep-alive',
        'Authorization: Basic UFdDQUJBUDphc2FwNEAxODA5',
        'Cookie: sap-usercontext=sap-client=120'
        ),
        ));
        curl_setopt(
        $curl,
        CURLOPT_HEADERFUNCTION,
        function ($curl2, $header) use (&$headers) {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        if (count($header) <  2) // ignore invalid headers
        return $len;

        $headers[strtolower(trim($header[0]))] = trim($header[1]);
        return $len;
        }
        );

        curl_exec($curl);
        return $headers;
    }
}
