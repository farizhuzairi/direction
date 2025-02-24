<?php

namespace Director;

use Director\Accessible;
use Director\Services\WebService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class DirectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Accessible::class, function (Application $app) {
            return new WebService(null);
        });
    }
    
    public function boot(): void
    {
        //
    }
}
