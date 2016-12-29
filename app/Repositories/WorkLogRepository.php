<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WorkLogRepository
{
    public function sync(User $user, Project $project, array $workLogsData = [], Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        [$new, $existing] = collect($workLogsData)
            ->partition(function ($workLogData) {
                return isset($workLogData['id']);
            })
            ->all();

        \DB::transaction(function () use ($user, $project, $existing, $new, $dateFrom, $dateTo) {
            $this->syncDelete($user, $project, $existing, $dateFrom, $dateTo);
            $this->syncUpdate($existing);
            $this->syncCreate($user, $project, $new);
        });
    }

    /**
     * Remove work logs not mentioned in sync
     *
     * @param User        $user
     * @param Project     $project
     * @param Collection  $existing
     * @param Carbon|null $dateFrom
     * @param Carbon|null $dateTo
     */
    protected function syncDelete(User $user, Project $project, Collection $existing, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $query = WorkLog::where([
            'user_id'    => $user->id,
            'project_id' => $project->id,
        ])
            ->whereNotIn('id', $existing->pluck('id'));

        if ($dateFrom !== null) {
            $query->where('date', '>=', $dateFrom);
        }

        if ($dateTo !== null) {
            $query->where('date', '<=', $dateTo);
        }

        $query->each(function (WorkLog $workLog) {
            $workLog->delete();
        });
    }

    /**
     * Update existings work logs
     *
     * @param Collection $existing
     */
    protected function syncUpdate(Collection $existing)
    {
        $existing->each(function (array $workLogData) {
            $workLog = WorkLog::findOrFail($workLogData['id']);

            unset($workLogData['id']);
            unset($workLogData['project_id']);

            $workLog->update($workLogData);
        });
    }

    /**
     * Create new work logs
     *
     * @param User       $user
     * @param Project    $project
     * @param Collection $new
     */
    protected function syncCreate(User $user, Project $project, Collection $new)
    {
        $new->each(function (array $workLogData) use ($user, $project) {
            $workLogData['project_id'] = $project->id;

            $user->workLogs()
                ->create($workLogData);
        });
    }
}