<?php
namespace App\Builders\Breadcrumb;

class Breadcrumb
{
    /**
     * Breadcrumb name
     *
     * @var string
     */
    protected $name;

    /**
     * Breadcrumb link
     *
     * @var string
     */
    protected $url;

    public function __construct(array $attributes = [])
    {
        $this->name = array_get($attributes, 'name');
        $this->url = array_get($attributes, 'url');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}