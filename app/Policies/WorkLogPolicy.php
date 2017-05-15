<?php
namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkLogPolicy
{
    use HandlesAuthorization;

    public function store(User $user, Project $project)
    {
        return $project->active;
    }

    public function update(User $user, WorkLog $workLog)
    {
        return $workLog->editable;
    }
}
