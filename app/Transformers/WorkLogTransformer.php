<?php
namespace App\Transformers;

use App\Models\WorkLog;
use League\Fractal\TransformerAbstract;

class WorkLogTransformer extends TransformerAbstract
{
    public function transform(WorkLog $workLog)
    {
        return [
            'id'   => $workLog->id,
            'date' => $workLog->date->toDateString(),
            'time' => $workLog->time,
            'type' => $workLog->type,
        ];
    }
}