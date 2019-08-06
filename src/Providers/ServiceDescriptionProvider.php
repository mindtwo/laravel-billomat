<?php

namespace Mindtwo\LaravelBillomat\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Mindtwo\LaravelBillomat\ServiceDescription;

class ServiceDescriptionProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        ServiceDescription::class => ServiceDescription::class,
    ];

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ServiceDescription::class];
    }
}
