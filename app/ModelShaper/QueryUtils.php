<?php
namespace App\ModelShaper;

abstract class QueryUtils
{
    public static function valueForLike(string $search)
    {
        return '%' . implode('%', str_split($search)) . '%';
    }

    public static function isTrue(string $value)
    {
        return $value === "true" || $value === "True";
    }
}
