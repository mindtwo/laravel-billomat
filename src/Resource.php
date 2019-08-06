<?php

namespace Mindtwo\LaravelBillomat;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Mindtwo\LaravelBillomat\Exceptions\Exception;

class Resource
{
    const BLUEPRINT = [
        'get' => [
            'type'     => 'GET',
            'requires' => [],
        ],
        'find' => [
            'type'     => 'GET',
            'requires' => ['id'],
        ],
        'create' => [
            'type'     => 'POST',
            'requires' => [],
        ],
        'update' => [
            'type'     => 'PUT',
            'requires' => [],
        ],
        'delete' => [
            'type'     => 'GET',
            'requires' => ['id'],
        ],
    ];

    /**
     * Resource configuration.
     *
     * @var Collection
     */
    protected $config;

    /**
     * Resource name.
     *
     * @var string
     */
    protected $name;

    /**
     * Resource method to use.
     *
     * @var string
     */
    protected $use_method;

    /**
     * Resource constructor.
     *
     * @param string $name
     * @param array  $config
     */
    public function __construct(string $name, array $config = [])
    {
        $this->name = $name;
        $this->config = Collection::make(self::BLUEPRINT)->merge($config);
    }

    /**
     * Determinate if a method exists on this resource.
     *
     * @param string $method
     *
     * @return bool
     */
    public function methodExists(string $method): bool
    {
        return $this->config->has($method);
    }

    /**
     * Use method on this resource.
     *
     * @param string $method
     *
     * @throws Exception
     *
     * @return resource
     */
    public function useMethod(string $method): self
    {
        if (! $this->methodExists($method)) {
            throw new Exception('Resource method is not defined');
        }

        $this->use_method = $method;

        return $this;
    }

    /**
     * Get configuration of a resource method.
     *
     * @param string $key
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function methodConfig(string $key)
    {
        if (empty($this->use_method)) {
            throw new Exception('Resource method not set');
        }

        $config = $this->config->get($this->use_method);

        return $config[$key] ?? null;
    }

    /**
     * Get the HTTP query type.
     *
     * @throws Exception
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->methodConfig('type');
    }

    /**
     * Get the query URI.
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->parameterReplace(
            Config::get('billomat-service-description.base_uri'),
            [
                'billomatID' => Config::get('billomat.billomat_id'),
                'ressource'  => $this->name,
            ]
        );
    }

    /**
     * Replace template parameters in a string.
     *
     * @param string $string
     * @param array  $parameters
     *
     * @return string
     */
    protected function parameterReplace(string $string, array $parameters = []): string
    {
        foreach ($parameters as $key => $value) {
            $string = str_replace(sprintf('{%s}', $key), $value, $string);
        }

        return $string;
    }
}
