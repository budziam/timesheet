<?php
namespace App\Utils;

use Carbon\Carbon;

abstract class DateUtils
{
    public static function formatEndsAt(Carbon $date = null) : string
    {
        if ($date === null) {
            return __('Never');
        }

        return $date->toDateString();
    }

    public static function formatWorkLogTime($time) : string
    {
        $hours = (int)floor($time / 3600);
        $minutes = (int)floor(($time - $hours * 3600) / 60);

        $minutesPretty = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $hoursPretty = str_pad($hours, 2, '0', STR_PAD_LEFT);

        return "{$hoursPretty}:{$minutesPretty}";
    }
}