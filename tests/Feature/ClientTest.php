<?php

namespace Mindtwo\LaravelBillomat\Tests\Feature;

use Mindtwo\LaravelBillomat\Client;
use Mindtwo\LaravelBillomat\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * Example.
     *
     * @test
     */
    public function testClientGetRequest()
    {
        $client = $this->app->make(Client::class);
        //$response = $client->clients()->get();
        //dd($response);
        $this->assertTrue(true);
    }
}
