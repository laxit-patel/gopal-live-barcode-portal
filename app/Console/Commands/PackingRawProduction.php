<?php

namespace App\Console\Commands;

use App\Models\BarcodeMachineMaster;
use App\Models\Configuration;
use App\Models\DispatchMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use App\Models\RawPackingMaster;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PackingRawProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Production:RawPacking';

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
        set_time_limit(0);
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
        while (true) {
            $ConfigData = Configuration::first('rawPacking');
            $rawPacking = $ConfigData->rawPacking;
            if ($rawPacking != 'Off' && !empty($rawPacking)) {
                
                

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
                    //echo $barcode;exit;
                    if (!empty($barcode)) {
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
                                $data = new RawDispatchMaster;
                                $data->machine_id = $machine_id;
                                $data->plant_id = $plant_id;
                                $data->line_id = $line_id;
                                $data->barcode = $barcode;
                                $data->product_id =  $dispatchData->product_id;
                                $data->save();
                            }
                        }
                        //socket_close($socket);
                        log::debug('socket closed');
                        $this->info('Updated on raw packing ' . $machine->type);
                    } else {
                        $this->info('empty barcode - ' . $machine->type);
                    }
                }
            }
        }
        // set_time_limit(0);
        // $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
        // $machineData = BarcodeMachineMaster::where('type', 'packing')->get();
        // foreach ($machineData as $machine) {
        //     $machine_id = $machine->machine_id;
        //     $plant_id = $machine->plant_id;
        //     $line_id = $machine->line_id;
        //     $host = $machine->ip_address;
        //     $port = $machine->port;

        //     $result = socket_connect($socket, $host, $port) or die("Could not bind to socket\n");
        //     $input = socket_read($socket, 1024) or die("Could not read input\n");
        //     $barcode = trim($input);

        //     $productData = ProductMaster::where('barcode', $barcode)->first('product_id');
        //     if (!empty($productData->product_id)) {
        //         $data = new RawPackingMaster;
        //         $data->machine_id = $machine_id;
        //         $data->plant_id = $plant_id;
        //         $data->line_id = $line_id;
        //         $data->barcode = $barcode;
        //         $data->product_id = $productData->product_id;
        //         $data->save();
        //     }
        // }
        $this->info('Updated on raw packing');
    }
}
