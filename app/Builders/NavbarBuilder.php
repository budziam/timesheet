<?php
namespace App\Builders;

class NavbarBuilder
{
    protected $active;

    public function setActive($name)
    {
        $this->active = $name;
    }

    /**
     * Returns class active if active page matches
     *
     * @param string $name
     * @return null|string
     */
    public function check($name)
    {
        return $name === $this->active ? 'active' : '';
    }
}