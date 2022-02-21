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
    }
}
