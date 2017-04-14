<?php
namespace App\Utils;

use Carbon\Carbon;

abstract class DateUtils
{
    public static function formatEndsAt(?Carbon $date) : string
    {
        if ($date === null) {
            return __('Never');
        }

        return $date->toDateTimeString();
    }
}