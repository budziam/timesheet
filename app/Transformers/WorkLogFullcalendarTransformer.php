<?php
namespace App\Transformers;

use App\Models\WorkLog;
use App\Utils\WorkLogTypeUtils;
use League\Fractal\TransformerAbstract;

class WorkLogFullcalendarTransformer extends TransformerAbstract
{
    public function transform(WorkLog $workLog)
    {
        return [
            'id'              => $workLog->id,
            'title'           => $this->getTitle($workLog),
            'date'            => $workLog->date->toDateString(),
            'time'            => $workLog->time,
            'backgroundColor' => WorkLogTypeUtils::getColor($workLog->type),
        ];
    }

    protected function getTitle(WorkLog $workLog)
    {
        return WorkLogTypeUtils::getName($workLog->type) . ': ' . $workLog->timePretty();
    }
}