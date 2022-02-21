<?php

namespace App\Jobs;

use App\Models\BarcodeMachineMaster;
use App\Models\Configuration;
use App\Models\DispatchMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use App\Models\RawPackingMaster;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetBarcode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ConfigData = Configuration::first();
        $rawPacking = $ConfigData->rawPacking;
        if ($rawPacking != 'Off' && !empty($rawPacking)) {
            set_time_limit(0);
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");

            $machineData = BarcodeMachineMaster::get();
            foreach ($machineData as $machine) {
                $machine_id = $machine->machine_id;
                $plant_id = $machine->plant_id;
                $line_id = $machine->line_id;
                $host = $machine->ip_address;
                $port = $machine->port;

                $result = socket_connect($socket, $host, $port) or die("Could not bind to socket\n");
                $input = socket_read($socket, 1024) or die("Could not read input\n");
                $barcode = trim($input);
                if ($machine->type == 'packing') {
                    $productData = ProductMaster::where('barcode', $barcode)->first('product_id');
                    if (!empty($productData->product_id)) {
                        $data = new RawPackingMaster;
                        $data->machine_id = $machine_id;
                        $data->plant_id = $plant_id;
                        $data->line_id = $line_id;
                        $data->barcode = $barcode;
                        $data->product_id = $productData->product_id;
                        $data->save();
                    }
                } elseif ($machine->type == 'dispatch') {
                    $dispatchData = DispatchMaster::where('barcode', $barcode)->where('plant_id', $plant_id)->where('line_id', $line_id)->first(['product_id']);
                    if (!empty($dispatchData)) {
                        $data = new RawDispatchMaster();
                        $data->machine_id = $machine_id;
                        $data->plant_id = $plant_id;
                        $data->line_id = $line_id;
                        $data->barcode = $barcode;
                        $data->product_id =  $dispatchData->product_id;
                        $data->save();
                    }
                }
            }
        }
    }
}
