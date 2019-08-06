<?php

namespace Mindtwo\LaravelBillomat;

use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mindtwo\LaravelBillomat\Exceptions\Exception;

class ServiceDescription
{
    /**
     * Config.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Resource definitions.
     *
     * @var Collection
     */
    protected $resources;

    /**
     * ServiceDescription constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->resources = Collection::make($config->get('billomat-service-description.resources'));
    }

    /**
     * Get a resource as object.
     *
     * @param string $name
     *
     * @throws Exception
     *
     * @return resource
     */
    public function getResource(string $name): Resource
    {
        if (! $this->hasResource($name)) {
            throw new Exception('Resource is not defined');
        }

        return new Resource($name, $this->resources->get(Str::kebab($name)));
    }

    /**
     * Determinate if a resource exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasResource(string $name): bool
    {
        return $this->resources->has(Str::kebab($name));
    }
}
