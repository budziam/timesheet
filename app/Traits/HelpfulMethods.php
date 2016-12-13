<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @method static $this firstOrFail()
 */
trait HelpfulMethods
{
    public static function instance()
    {
        return new static;
    }

    public static function table()
    {
        return static::instance()->getTable();
    }

    public static function keyName()
    {
        return static::instance()->getKeyName();
    }

    /**
     * @param \Eloquent $query
     * @return static
     */
    public function scopeFirstOrFail($query)
    {
        $model = $query->first();

        if ($model !== null) {
            return $model;
        }

        throw (new ModelNotFoundException)->setModel(static::class);
    }
}