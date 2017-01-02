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
            'time_fieldwork'  => $workLog->time_fieldwork,
            'time_office'     => $workLog->time_office,
            'backgroundColor' => $this->colorFromName($workLog->project->name),
        ];
    }

    protected function colorFromName($str)
    {
        $c = strtoupper(dechex(abs(crc32($str)) & 0x00FFFFFF));

        return '#' . str_pad($c, 6, '0', STR_PAD_LEFT);
    }
}