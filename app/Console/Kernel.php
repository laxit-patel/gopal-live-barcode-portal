<?php

namespace App\Console;

use App\Models\Configuration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $true = true;
        // while ($true) {
        //     $ConfigData = Configuration::first();
        //     $rawPacking = $ConfigData->rawPacking;
        //     if ($rawPacking != 'Off' && !empty($rawPacking)) {
        //         $true = true;
        //         $schedule->command('Production:RawPacking')->everyMinute();
        //         // $schedule->command('Dispatch:Raw')->everyMinute();
        //     } else {
        //         $true = false;
        //     }
        // }
        $ConfigData = Configuration::first();
        $productionVoucher = $ConfigData->productionVoucher;
        if ($productionVoucher != 'Off' && !empty($productionVoucher)) {
            $schedule->command('Production:Voucher')->$productionVoucher();
            Log::debug('Voucher_test');
        }

        $schedule->command('db:sync')->daily();
        Log::debug('Syncing..');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
