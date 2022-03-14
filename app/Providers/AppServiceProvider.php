<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\BarcodeMachineMaster;
use App\Observers\NewIPObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BarcodeMachineMaster::observe(NewIPObserver::class);
    }
}
