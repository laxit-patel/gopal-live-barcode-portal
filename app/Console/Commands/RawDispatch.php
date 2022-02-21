<?php

namespace App\Console\Commands;

use App\Models\BarcodeMachineMaster;
use App\Models\DispatchMaster;
use App\Models\ProductMaster;
use App\Models\RawDispatchMaster;
use Illuminate\Console\Command;

class RawDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dispatch:Raw';

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
        $machineData = BarcodeMachineMaster::where('type', 'dispatch')->get();
        foreach ($machineData as $machine) {
            $machine_id = $machine->machine_id;
            $plant_id = $machine->plant_id;
            $line_id = $machine->line_id;
            $host = $machine->ip_address;
            $port = $machine->port;

            $result = socket_connect($socket, $host, $port) or die("Could not bind to socket\n");
            $input = socket_read($socket, 1024) or die("Could not read input\n");
            $barcode = trim($input);

            // $productData = ProductMaster::where('barcode', $barcode)->first('product_id');
            $dispatchData = DispatchMaster::where('barcode', $barcode)->where('plant_id', $plant_id)->where('line_id', $line_id)->first(['product_id']);
            // $this->info($dispatchData);
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
        $this->info('Updated on raw dispatch');
    }
}
