<?php
namespace App\Utils;

abstract class WorkLogUtils
{
    public static function getTimePretty($time)
    {
        $hours = (int)floor($time / 60 / 60);
        $minutes = (int)floor(($time % 3600) / 60);

        return "{$hours}g {$minutes}m";
    }
}