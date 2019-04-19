<?php
namespace App\Datatables;

use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\User;
use App\Models\WorkLog;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkLogRepository;
use App\Services\ProjectFilterService;
use App\Utils\DateUtils;
use DB;
use Illuminate\Database\Events\QueryExecuted;
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

    /** @var ProjectFilterService */
    protected $projectFilterService;

    public function __construct(
        WorkLogRepository $workLogRepository,
        ProjectRepository $projectRepository,
        UserRepository $userRepository,
        ProjectFilterService $projectFilterService
    ) {
        $this->workLogRepository = $workLogRepository;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->projectFilterService = $projectFilterService;
    }

    public function initBuilder()
    {
        $userTable = User::table();
        $workLogTable = WorkLog::table();
        $projectTable = Project::table();
        $projectGroupTable = ProjectGroup::table();
        $pivotTable = "project_project_group";

        $this->builder = WorkLog::query()
            ->with("project", "user")
            ->leftJoin($projectTable, "$workLogTable.project_id", '=', "$projectTable.id")
            ->leftJoin($pivotTable, "$pivotTable.project_id", '=', "$projectTable.id")
            ->leftJoin($projectGroupTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->leftJoin($userTable, "$workLogTable.user_id", '=', "$userTable.id")
            ->select("$workLogTable.*");
    }

    protected function filterByFilters($query, array $filters)
    {
        $this->projectFilterService->filterByYear($query, $filters);
        $this->projectFilterService->filterByCustomer($query, $filters);
        $this->projectFilterService->filterByGroups($query, $filters);
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
