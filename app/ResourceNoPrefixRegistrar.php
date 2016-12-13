<?php
namespace App;

use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Router;

class ResourceNoPrefixRegistrar extends ResourceRegistrar
{
    public function __construct(Router $router)
    {
        parent::__construct($router);
    }

    /**
     * Get the resource name for a grouped resource.
     *
     * @param  string $prefix
     * @param  string $resource
     * @param  string $method
     * @return string
     */
    protected function getGroupResourceName($prefix, $resource, $method)
    {
        // vsch: don't add prefix to the route name, if you want a prefix added to the route name add 'as' => 'prefix.'
        // to the group options
        return trim("{$prefix}{$resource}.{$method}", '.');
    }
}