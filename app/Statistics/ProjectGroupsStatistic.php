<?php
namespace App\Statistics;

use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\WorkLog;
use App\Services\ProjectFilterService;
use DB;
use Illuminate\Support\Collection;

class ProjectGroupsStatistic
{
    /** @var ProjectFilterService */
    private $projectFilterService;

    public function __construct(ProjectFilterService $projectFilterService)
    {
        $this->projectFilterService = $projectFilterService;
    }

    public function get(array $filters = [])
    {
        $totalTime = $this->getTotalTime($filters);
        $totalValue = $this->getTotalValue($filters);
        $results = $this->getResults($filters);

        return [
            'all'            => [
                'office'    => (int)$totalTime['office'],
                'fieldwork' => (int)$totalTime['fieldwork'],
                'value'     => $totalValue,
            ],
            'project_groups' => $results,
        ];
    }

    protected function getTotalTime(array $filters) : array
    {
        $workLogTable = WorkLog::table();
        $projectTable = Project::table();

        $query = DB::table($workLogTable)
            ->join($projectTable, "$workLogTable.project_id", "=", "$projectTable.id")
            ->select([
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ]);

        $this->applyFilters($query, $filters);

        return (array)$query->first();
    }

    protected function getTotalValue(array $filters) : int
    {
        $projectTable = Project::table();

        $query = DB::table($projectTable);
        $this->applyFilters($query, $filters);

        return (int)$query->sum('value');
    }

    protected function getResults(array $filters) : Collection
    {
        $times = $this->getTimes($filters);
        $values = $this->getValues($filters);

        return ProjectGroup::all()
            ->toBase()
            ->map(function (ProjectGroup $projectGroup) use ($times, $values) {
                return [
                    'project_group' => $projectGroup->name,
                    'office'        => $times[$projectGroup->id]['office'] ?? 0,
                    'fieldwork'     => $times[$projectGroup->id]['fieldwork'] ?? 0,
                    'value'         => $values[$projectGroup->id] ?? 0,
                ];
            });
    }

    protected function getTimes(array $filters) : Collection
    {
        $projectGroupTable = ProjectGroup::table();
        $workLogTable = WorkLog::table();
        $projectTable = Project::table();
        $pivotTable = 'project_project_group';

        $query = DB::table($projectGroupTable)
            ->select([
                "$projectGroupTable.id",
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($projectTable, "$pivotTable.project_id", '=', "$projectTable.id")
            ->join($workLogTable, "$pivotTable.project_id", '=', "$workLogTable.project_id");

        $this->applyFilters($query, $filters);

        return $query
            ->groupBy("$projectGroupTable.id")
            ->get()
            ->mapWithKeys(function ($result) {
                return [
                    (int)$result->id => [
                        'office'    => (int)$result->office,
                        'fieldwork' => (int)$result->fieldwork,
                    ],
                ];
            });
    }

    protected function getValues(array $filters) : Collection
    {
        $projectGroupTable = ProjectGroup::table();
        $projectTable = Project::table();
        $pivotTable = 'project_project_group';

        $query = DB::table($projectGroupTable)
            ->select([
                "$projectGroupTable.id",
                DB::raw("SUM($projectTable.value) as value"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($projectTable, "$pivotTable.project_id", '=', "$projectTable.id");

        $this->applyFilters($query, $filters);

        return $query
            ->groupBy("$projectGroupTable.id")
            ->get()
            ->mapWithKeys(function ($result) {
                return [(int)$result->id => (int)$result->value];
            });
    }

    private function applyFilters($query, array $filters)
    {
        $this->projectFilterService->filterByYear($query, $filters);
        $this->projectFilterService->filterByOnlyCompleted($query, $filters);
    }
}
