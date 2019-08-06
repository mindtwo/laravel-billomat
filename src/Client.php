<?php

namespace Mindtwo\LaravelBillomat;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Client extends \GuzzleHttp\Client
{
    /**
     * Billomat API resource.
     *
     * @var resource
     */
    protected $resource;

    /**
     * Service description.
     *
     * @var ServiceDescription
     */
    protected $service;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        $this->service = App::make(ServiceDescription::class);

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args)
    {
        if ($this->service->hasResource($method)) {
            $this->resource = $this->service->getResource($method);

            return $this;
        } elseif ($this->resource instanceof Resource) {
            return $this->requestResource($method, $args);
        }

        return parent::__call($method, $args);
    }

    /**
     * Make a request on a resource with the specified method.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function requestResource(string $method, array $arguments = [])
    {
        $this->resource->useMethod($method);

        return $this->request(
            $this->resource->getType(),
            $this->resource->getUri(),
            [
                'headers' => $this->getBillomatHeaders(),
            ]
        );
    }

    /**
     * Get the header for the billomat API.
     *
     * @return array
     */
    public function getBillomatHeaders(): array
    {
        return [
            'X-BillomatApiKey' => Config::get('billomat.api_key'),
        ];
    }
}
