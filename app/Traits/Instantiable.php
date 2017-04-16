<?php
namespace App\Traits;

trait Instantiable
{
    /**
     * @return static
     */
    public static function make()
    {
        return app(static::class);
    }
}