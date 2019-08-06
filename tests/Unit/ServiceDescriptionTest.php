<?php

namespace Mindtwo\LaravelBillomat\Tests\Unit;

use Mindtwo\LaravelBillomat\Client;
use Mindtwo\LaravelBillomat\Resource;
use Mindtwo\LaravelBillomat\ServiceDescription;
use Mindtwo\LaravelBillomat\Tests\TestCase;

class BillomatServiceDescriptionTest extends TestCase
{
    /**
     * Has resource method test.
     *
     * @test
     */
    public function testHasResourceMethod()
    {
        $service = $this->app->make(ServiceDescription::class);

        $this->assertTrue($service->hasResource('clients'));
        $this->assertFalse($service->hasResource('unknown-resource'));
    }

    /**
     * Get resource method test.
     *
     * @test
     */
    public function testGetResourceMethod()
    {
        $service = $this->app->make(ServiceDescription::class);

        $this->assertInstanceOf(Resource::class,  $service->getResource('clients'));
    }
}
