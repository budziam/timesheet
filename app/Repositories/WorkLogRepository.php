<?php
namespace App\Repositories;

use App\Models\WorkLog;

class WorkLogRepository
{
    public function getLink(WorkLog $workLog, string $title = null) : string
    {
        $title = $title ?? $workLog->id;

        return link_to_route('dashboard.work-logs.edit', $title, $workLog->getRouteKey());
    }
}