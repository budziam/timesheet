<?php
namespace App\Statistics;

use App\Models\Customer;
use App\Models\Project;
use App\Models\WorkLog;
use DB;
use Illuminate\Support\Collection;

class CustomersStatistic
{
    public function get() : array
    {
        $times = $this->getTimes();
        $values = $this->getValues();

        return Customer::all()
            ->map(function (Customer $customer) use ($times, $values) {
                return [
                    'customer'  => $customer->name,
                    'office'    => $times[$customer->id]['office'] ?? 0,
                    'fieldwork' => $times[$customer->id]['fieldwork'] ?? 0,
                    'value'     => $values[$customer->id] ?? 0,
                ];
            })
            ->all();
    }

    protected function getTimes() : Collection
    {
        $customerTable = Customer::table();
        $projectTable = Project::table();
        $workLogTable = WorkLog::table();

        return DB::table($customerTable)
            ->select([
                "$customerTable.id",
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->join($projectTable, "$projectTable.customer_id", '=', "$customerTable.id")
            ->join($workLogTable, "$projectTable.id", '=', "$workLogTable.project_id")
            ->groupBy("$customerTable.id")
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
        $customerTable = Customer::table();
        $projectTable = Project::table();

        return DB::table($customerTable)
            ->select([
                "$customerTable.id",
                DB::raw("SUM($projectTable.value) as value"),
            ])
            ->join($projectTable, "$projectTable.customer_id", '=', "$customerTable.id")
            ->groupBy("$customerTable.id")
            ->get()
            ->mapWithKeys(function ($result) {
                return [(int)$result->id => (int)$result->value];
            });
    }
}