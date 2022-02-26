<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerMaster;

class sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command syncs customer master and product master from dealer portal';

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
        $customers = DB::connection('dealer')->table('customers')->get();
        CustomerMaster::truncate();

        foreach($customers as $record)
        {
            CustomerMaster::create([
                'customer_number' => $record->customer_number,
                'name' => $record->name,
                'city' => $record->city,
                'district' => $record->district,
                'street_1' => $record->street_1,
                'street_2' => $record->street_2,
                'street_3' => $record->street_3,
                'distribution_channel' => $record->distribution_channel,
                'sales_organization' => $record->sales_organization,
                'plant' => $record->plant,
                'sold_to_party' => $record->sold_to_party,
                'ship_to_party_1' => $record->ship_to_party_1,
                'ship_to_party_2' => $record->ship_to_party_2,
                'ship_to_party_3' => $record->ship_to_party_3,
                'price_group' => $record->price_group,
                'price_list_type' => $record->price_list_type,
            ]);
        }
        $this->question("Synced");
    }
}
