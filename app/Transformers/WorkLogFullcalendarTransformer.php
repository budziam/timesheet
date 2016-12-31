<?php
namespace App\Transformers;

use App\Models\WorkLog;
use App\Utils\WorkLogUtils;
use League\Fractal\TransformerAbstract;

class WorkLogFullcalendarTransformer extends TransformerAbstract
{
    public function transform(WorkLog $workLog)
    {
        return [
            'id'    => $workLog->id,
            'title' => $workLog->project->name,
            'date'  => $workLog->date->toDateString(),

            'time_fieldwork' => WorkLogUtils::getTimePretty($workLog->time_fieldwork),
            'time_office'    => WorkLogUtils::getTimePretty($workLog->time_office),
        ];
    }
}