<?php
namespace App\Datatables;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkLogRepository;
use App\Utils\DateUtils;
use DB;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\BaseDatatable;
use ModelShaper\QueryUtils;

class WorkLogDatatable extends BaseDatatable
{
    /** @var WorkLogRepository */
    protected $workLogRepository;

    /** @var ProjectRepository */
    protected $projectRepository;

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(
        WorkLogRepository $workLogRepository,
        ProjectRepository $projectRepository,
        UserRepository $userRepository
    ) {
        $this->workLogRepository = $workLogRepository;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
    }

    public function initBuilder()
    {
        $pTable = Project::table();
        $uTable = User::table();
        $wTable = WorkLog::table();

        $this->builder = WorkLog::query()
            ->leftJoin($pTable, "{$wTable}.project_id", '=', "{$pTable}.id")
            ->leftJoin($uTable, "{$wTable}.user_id", '=', "{$uTable}.id")
            ->select("{$wTable}.*");
    }

    protected function filterByFilters($query, array $filters)
    {
        $pTable = Project::table();

        if (array_has($filters, 'start_years')) {
            $query->whereIn(DB::raw("YEAR({$pTable}.created_at)"), $filters['start_years']);
        }

        if (array_has($filters, 'end_years')) {
            $query->whereIn(DB::raw("YEAR({$pTable}.ends_at)"), $filters['end_years']);
        }
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (WorkLog $workLog) {
                return [
                    'id'             => [
                        'display' => $this->workLogRepository->getLink($workLog, '#' . $workLog->id),
                        'raw'     => $workLog->id,
                    ],
                    'project'        => $this->projectRepository->getLink($workLog->project),
                    'user'           => $this->userRepository->getLink($workLog->user),
                    'date'           => $workLog->date->toDateString(),
                    'time_fieldwork' => DateUtils::formatWorkLogTime($workLog->time_fieldwork),
                    'time_office'    => DateUtils::formatWorkLogTime($workLog->time_office),
                ];
            });
    }

    protected function filterByProject($query, string $search)
    {
        $pTable = Project::table();
        $query->where("{$pTable}.lkz", 'LIKE', QueryUtils::valueForLike($search));
    }

    protected function filterByUser($query, string $search)
    {
        $uTable = User::table();
        $query->where("{$uTable}.fullname", 'LIKE', QueryUtils::valueForLike($search));
    }

    protected function orderByProject($query, string $order)
    {
        $pTable = Project::table();
        $query->orderBy("{$pTable}.lkz", $order);
    }

    protected function orderByUser($query, string $order)
    {
        $uTable = User::table();
        $query->orderBy("{$uTable}.fullname", $order);
    }
}
