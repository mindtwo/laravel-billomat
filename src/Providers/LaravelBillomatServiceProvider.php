<?php

namespace Mindtwo\LaravelBillomat\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelBillomatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/ServiceDescription.php' => config_path('billomat-service-description.php'),
            __DIR__.'/../Config/Config.php' => config_path('billomat.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/ServiceDescription.php', 'billomat-service-description'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../Config/Config.php', 'billomat'
        );
    }
}
