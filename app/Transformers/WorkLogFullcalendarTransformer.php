<?php
namespace App\Transformers;

use App\Models\WorkLog;
use League\Fractal\TransformerAbstract;

class WorkLogFullcalendarTransformer extends TransformerAbstract
{
    public function transform(WorkLog $workLog)
    {
        return [
            'id'              => $workLog->id,
            'title'           => $workLog->project->name,
            'date'            => $workLog->date->toDateString(),
            'project_id'      => $workLog->project->id,
            'time_fieldwork'  => $workLog->time_fieldwork,
            'time_office'     => $workLog->time_office,
            'comment'         => $workLog->comment,
            'backgroundColor' => $workLog->project->color,
            'editable'        => $workLog->editable,
        ];
    }
}