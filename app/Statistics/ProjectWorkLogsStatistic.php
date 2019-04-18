<?php
namespace App\Statistics;

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use DB;

class ProjectWorkLogsStatistic
{
    public function get(Project $project) : array
    {
        $userTable = User::table();
        $workLogTable = WorkLog::table();

        $results = DB::table($workLogTable)
            ->select([
                DB::raw("$userTable.fullname as employee"),
                DB::raw("YEAR($workLogTable.date) as year"),
                DB::raw("MONTH($workLogTable.date) as month"),
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
                DB::raw("SUBSTRING_INDEX($userTable.fullname, ' ', 1) as first_name"),
                DB::raw("SUBSTRING_INDEX($userTable.fullname, ' ', -1) as last_name"),
            ])
            ->where("$workLogTable.project_id", $project->id)
            ->join($userTable, "$userTable.id", '=', "$workLogTable.user_id")
            ->groupBy("$workLogTable.user_id", 'year', 'month', 'employee')
            ->orderBy('last_name')
            ->orderBy('first_name')
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

        return $this->addSummaryRecords($results);
    }

    private function addSummaryRecords(array $records)
    {
        $newRecords = [];
        $currentEmployee = null;
        $officeSum = 0;
        $fieldworkSum = 0;

        foreach ($records as $record) {
            if ($record['employee'] !== $currentEmployee) {
                $newRecords []= [
                    'employee'  => $currentEmployee,
                    'date'      => null,
                    'office'    => $officeSum,
                    'fieldwork' => $fieldworkSum,
                ];

                $officeSum = 0;
                $fieldworkSum = 0;
                $currentEmployee = $record['employee'];
            }

            $officeSum += $record['office'];
            $fieldworkSum += $record['fieldwork'];
            $newRecords []= $record;
        }

        $newRecords []= [
            'employee'  => $currentEmployee,
            'date'      => null,
            'office'    => $officeSum,
            'fieldwork' => $fieldworkSum,
        ];

        array_shift($newRecords);

        return $newRecords;
    }
}
