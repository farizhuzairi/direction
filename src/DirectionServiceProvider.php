<?php

namespace Director;

use Director\Accessible;
use Illuminate\Http\Request;
use Director\Contracts\Traceable;
use Director\Services\WebService;
use Director\Services\TraceService;
use Director\Factory\RequestFactory;
use Director\Http\Middleware\Direct;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class DirectionServiceProvider extends ServiceProvider
{
    /**
     * Register Service
     * 
     * @return void
     */
    public function register(): void
    {
        $this->registration_services();
    }
    
    /**
     * Boot Service
     * 
     * @return void
     */
    public function boot(): void
    {
        $this->app['router']->pushMiddlewareToGroup('web', Direct::class);

        Request::macro('accessible', function() {
            return app(Accessible::class);
        });
    }

    /**
     * Registration services
     * 
     * @return void
     */
    protected function registration_services(): void
    {
        $this->app->bind(Traceable::class, function (Application $app) {
            return new TraceService(new RequestFactory());
        });

        $this->app->scoped(Accessible::class, function (Application $app) {
            return new WebService(
                $app->make(Traceable::class),
                $app->config['auth.providers.users.model'],
                $app->config['direction.services']
            );
        });
    }
}
