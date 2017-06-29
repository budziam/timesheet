<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Models\Project;
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
            ->groupBy('user_id', 'year', 'month')
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
}