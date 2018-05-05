<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\KdGService;

class KdGClientProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind("App\Services\KdGService",function()
       {
           return new KdGService();
       });
    }
}
