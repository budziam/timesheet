<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;

class WorkLogRepository
{
    public function create(User $user, Project $project, array $attributes = []) : WorkLog
    {
        $attributes['project_id'] = $project->id;

        return $user->workLogs()
            ->create($attributes);
    }
}