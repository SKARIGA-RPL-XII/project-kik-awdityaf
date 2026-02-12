<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure middleware aliases exist in case Kernel registration was missed
        if ($this->app->bound('router')) {
            $router = $this->app['router'];
            $router->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
            $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        }
    }
}
