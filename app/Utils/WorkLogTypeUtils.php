<?php
namespace App\Utils;

use App\Models\WorkLog;

abstract class WorkLogTypeUtils
{
    public static function getColor($type)
    {
        $colors = [
            WorkLog::TYPE_OFFICE    => '#0091ea',
            WorkLog::TYPE_FIELDWORK => '#5d4037',
        ];

        return $colors[$type];
    }

    public static function getName($type)
    {
        $colors = [
            WorkLog::TYPE_OFFICE    => trans('t.Office'),
            WorkLog::TYPE_FIELDWORK => trans('t.Fieldwork'),
        ];

        return $colors[$type];
    }
}