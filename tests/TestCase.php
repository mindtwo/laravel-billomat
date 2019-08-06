<?php

namespace Mindtwo\LaravelBillomat\Tests;

use Mindtwo\LaravelBillomat\Providers\LaravelBillomatServiceProvider;
use Mindtwo\LaravelBillomat\Providers\ServiceDescriptionProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelBillomatServiceProvider::class,
            ServiceDescriptionProvider::class
        ];
    }
}
