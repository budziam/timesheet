<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\User;
use App\Models\WorkLog;
use DB;

class StatisticsController extends BaseController
{
    public function projectWorkLogs(Project $project)
    {
        $userTable = User::table();
        $workLogTable = WorkLog::table();

        return DB::table($workLogTable)
            ->select([
                DB::raw("$userTable.fullname as employee"),
                DB::raw("YEAR($workLogTable.date) as year"),
                DB::raw("MONTH($workLogTable.date) as month"),
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->where("$workLogTable.project_id", $project->id)
            ->join($userTable, "$userTable.id", '=', "$workLogTable.user_id")
            ->groupBy("$workLogTable.user_id", 'year', 'month', 'employee')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($result) {
                return [
                    'employee'  => (string)$result->employee,
                    'date'      => $result->year . '-' . str_pad($result->month, 2, '0', STR_PAD_LEFT),
                    'office'    => (int)$result->office,
                    'fieldwork' => (int)$result->fieldwork,
                ];
            });
    }

    public function projectGroups()
    {
        $projectTable = Project::table();
        $projectGroupTable = ProjectGroup::table();
        $workLogTable = WorkLog::table();
        $pivotTable = 'project_project_group';

        $totalTime = DB::table($workLogTable)
            ->select([
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->first();

        $totalProject = DB::table($projectTable)
            ->select([
                DB::raw("SUM($projectTable.value) as value"),
            ])
            ->first();

        $results = DB::table($projectGroupTable)
            ->select([
                DB::raw("$projectGroupTable.name as project_group"),
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
                DB::raw("SUM($projectTable.value) as value"),
            ])
            ->join($pivotTable, "$pivotTable.project_group_id", '=', "$projectGroupTable.id")
            ->join($projectTable, "$pivotTable.project_id", '=', "$projectTable.id")
            ->join($workLogTable, "$projectTable.id", '=', "$workLogTable.project_id")
            ->groupBy("$projectGroupTable.id", "$projectGroupTable.name")
            ->get()
            ->map(function ($result) {
                return [
                    'project_group' => (string)$result->project_group,
                    'office'        => (int)$result->office,
                    'fieldwork'     => (int)$result->fieldwork,
                    'value'         => (int)$result->value,
                ];
            });

        return [
            'all'            => [
                'office'    => (int)$totalTime->office,
                'fieldwork' => (int)$totalTime->fieldwork,
                'value'     => (int)$totalProject->value,
            ],
            'project_groups' => $results,
        ];
    }
}