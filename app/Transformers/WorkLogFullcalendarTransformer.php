<?php
namespace App\Transformers;

use App\Models\WorkLog;
use League\Fractal\TransformerAbstract;

class WorkLogFullcalendarTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'project',
    ];

    public function transform(WorkLog $workLog)
    {
        return [
            'id'              => $workLog->id,
            'title'           => "",
            'date'            => $workLog->date->toDateString(),
            'time_fieldwork'  => $workLog->time_fieldwork,
            'time_office'     => $workLog->time_office,
            'comment'         => $workLog->comment,
            'backgroundColor' => $workLog->project->real_color,
            'editable'        => $workLog->editable,
        ];
    }

    public function includeProject(WorkLog $workLog)
    {
        return $this->item($workLog->project, new ProjectFullcalendarTransformer());
    }
}
