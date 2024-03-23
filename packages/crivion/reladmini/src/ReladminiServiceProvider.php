<?php

namespace Crivion\Reladmini;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Crivion\Reladmini\Http\Middleware\HandleReladminiInertiaRequests;

class ReladminiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'reladmini');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'reladmini');
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if ($this->app->runningInConsole()) {

            // Publishing configuration
            $this->publishes([
                __DIR__.'/config/config.php' => config_path('reladmini.php'),
            ], 'reladmini-config');

            // Publishing the routes
            $this->publishes([
                __DIR__.'/../routes/routes.php' => base_path('routes/reladmini.php')
            ], 'reladmini-routes');

            // Publishing the Blade views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/reladmini'),
            ], 'reladmini-views');

            // Publishing the React views
            $this->publishes([
                __DIR__.'/../resources/js/' => resource_path('js/Pages/Reladmini'),
            ], 'reladmini-views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/reladmini'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/reladmini'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        $this->bootInertia();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'reladmini');

        // Register the main class to use with the facade
        $this->app->singleton('reladmini', function () {
            return new Reladmini;
        });
    }

    /**
     * Boot any Inertia related services.
     *
     * @return void
     */
    protected function bootInertia()
    {
        // Append Inertia Middleware if path is for reladmini
        if(str_contains(request()->url(), config('reladmini.path'))) {
            $kernel = $this->app->make(Kernel::class);

            $kernel->appendMiddlewareToGroup('web', HandleReladminiInertiaRequests::class);
            $kernel->appendToMiddlewarePriority(HandleReladminiInertiaRequests::class);
        }
    }
}
