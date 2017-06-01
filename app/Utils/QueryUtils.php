<?php
namespace App\Utils;

abstract class QueryUtils
{
    public static function valueForLike(string $search)
    {
        return '%' . implode('%', str_split($search)) . '%';
    }
}