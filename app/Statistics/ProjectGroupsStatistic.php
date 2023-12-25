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
        $totalNetValue = $this->getTotalNetValue($filters);
        $results = $this->getResults($filters);

        return [
            'all'            => [
                'office'    => (int)$totalTime['office'],
                'fieldwork' => (int)$totalTime['fieldwork'],
                'net_value'     => $totalNetValue,
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

    protected function getTotalNetValue(array $filters) : int
    {
        $projectTable = Project::table();

        $query = DB::table($projectTable);
        $this->applyFilters($query, $filters);

        return (int)$query->sum('value') - (int)$query->sum('cost');
    }

    protected function getResults(array $filters) : Collection
    {
        $times = $this->getTimes($filters);
        $netValues = $this->getNetValues($filters);

        return ProjectGroup::all()
            ->toBase()
            ->map(function (ProjectGroup $projectGroup) use ($times, $netValues) {
                return [
                    'project_group' => $projectGroup->name,
                    'office'        => $times[$projectGroup->id]['office'] ?? 0,
                    'fieldwork'     => $times[$projectGroup->id]['fieldwork'] ?? 0,
                    'net_value'     => $netValues[$projectGroup->id] ?? 0,
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

    protected function getNetValues(array $filters) : Collection
    {
        $projectGroupTable = ProjectGroup::table();
        $projectTable = Project::table();
        $pivotTable = 'project_project_group';

        $query = DB::table($projectGroupTable)
            ->select([
                "$projectGroupTable.id",
                DB::raw("SUM($projectTable.value) as gross_value"),
                DB::raw("SUM($projectTable.cost) as cost"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($projectTable, "$pivotTable.project_id", '=', "$projectTable.id");

        $this->applyFilters($query, $filters);

        return $query
            ->groupBy("$projectGroupTable.id")
            ->get()
            ->mapWithKeys(function ($result) {
                return [(int)$result->id => (int)$result->gross_value - (int)$result->cost];
            });
    }

    private function applyFilters($query, array $filters)
    {
        $this->projectFilterService->filterByYear($query, $filters);
        $this->projectFilterService->filterByOnlyCompleted($query, $filters);
    }
}
