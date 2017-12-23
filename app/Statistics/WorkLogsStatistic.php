<?php
namespace App\Statistics;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use DB;

class WorkLogsStatistic
{
    public function get(Project $project) : array
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
            })
            ->all();
    }
}