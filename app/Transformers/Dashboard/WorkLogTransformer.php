<?php
namespace App\Transformers\Dashboard;

use App\Models\WorkLog;
use League\Fractal\TransformerAbstract;

class WorkLogTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'project',
        'user',
    ];

    public function transform(WorkLog $workLog)
    {
        return [
            'id'             => $workLog->id,
            'date'           => $workLog->date->toDateTimeString(),
            'time_fieldwork' => $workLog->time_fieldwork,
            'time_office'    => $workLog->time_office,
            'comment'        => $workLog->comment,
            'created_at'     => $workLog->created_at->toDateTimeString(),
            'updated_at'     => $workLog->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(WorkLog $workLog)
    {
        return $this->item($workLog->user, new UserTransformer());
    }

    public function includeProject(WorkLog $workLog)
    {
        return $this->item($workLog->project, new ProjectTransformer());
    }
}