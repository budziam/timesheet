<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkLogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, WorkLog $workLog)
    {
        return $workLog->editable;
    }
}
