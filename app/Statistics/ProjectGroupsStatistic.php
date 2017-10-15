<?php
namespace App\Statistics;

use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\WorkLog;
use DB;
use Illuminate\Support\Collection;

class ProjectGroupsStatistic
{
    public function get()
    {
        $totalTime = $this->getTotalTime();
        $totalValue = $this->getTotalValue();
        $results = $this->getResults();

        return [
            'all'            => [
                'office'    => (int)$totalTime['office'],
                'fieldwork' => (int)$totalTime['fieldwork'],
                'value'     => $totalValue,
            ],
            'project_groups' => $results,
        ];
    }

    protected function getTotalTime() : array
    {
        $workLogTable = WorkLog::table();

        return (array)DB::table($workLogTable)
            ->select([
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->first();
    }

    protected function getTotalValue() : int
    {
        $projectTable = Project::table();

        return (int)DB::table($projectTable)->sum('value');
    }

    protected function getResults() : Collection
    {
        $times = $this->getTimes();
        $values = $this->getValues();

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

    protected function getTimes() : Collection
    {
        $projectGroupTable = ProjectGroup::table();
        $workLogTable = WorkLog::table();
        $pivotTable = 'project_project_group';

        return DB::table($projectGroupTable)
            ->select([
                "$projectGroupTable.id",
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($workLogTable, "$pivotTable.project_id", '=', "$workLogTable.project_id")
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

    protected function getValues() : Collection
    {
        $projectGroupTable = ProjectGroup::table();
        $projectTable = Project::table();
        $pivotTable = 'project_project_group';

        return DB::table($projectGroupTable)
            ->select([
                "$projectGroupTable.id",
                DB::raw("SUM($projectTable.value) as value"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($projectTable, "$pivotTable.project_id", '=', "$projectTable.id")
            ->groupBy("$projectGroupTable.id")
            ->get()
            ->mapWithKeys(function ($result) {
                return [(int)$result->id => (int)$result->value];
            });
    }
}