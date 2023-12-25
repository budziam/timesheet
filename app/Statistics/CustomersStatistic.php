<?php
namespace App\Statistics;

use App\Models\Customer;
use App\Models\Project;
use App\Models\WorkLog;
use App\Services\ProjectFilterService;
use DB;
use Illuminate\Support\Collection;

class CustomersStatistic
{
    /** @var ProjectFilterService */
    private $projectFilterService;

    public function __construct(ProjectFilterService $projectFilterService)
    {
        $this->projectFilterService = $projectFilterService;
    }

    public function get(array $filters = []) : array
    {
        $times = $this->getTimes($filters);
        $netValues = $this->getNetValues($filters);

        return Customer::all()
            ->map(function (Customer $customer) use ($times, $netValues) {
                return [
                    'customer'  => $customer->name,
                    'office'    => $times[$customer->id]['office'] ?? 0,
                    'fieldwork' => $times[$customer->id]['fieldwork'] ?? 0,
                    'net_value' => $netValues[$customer->id] ?? 0,
                ];
            })
            ->all();
    }

    protected function getTimes(array $filters) : Collection
    {
        $customerTable = Customer::table();
        $projectTable = Project::table();
        $workLogTable = WorkLog::table();

        $query = DB::table($customerTable)
            ->select([
                "$customerTable.id",
                DB::raw("SUM($workLogTable.time_office) as office"),
                DB::raw("SUM($workLogTable.time_fieldwork) as fieldwork"),
            ])
            ->join($projectTable, "$projectTable.customer_id", '=', "$customerTable.id")
            ->join($workLogTable, "$projectTable.id", '=', "$workLogTable.project_id");

        $this->applyFilters($query, $filters);

        return $query->groupBy("$customerTable.id")
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
        $customerTable = Customer::table();
        $projectTable = Project::table();

        $query = DB::table($customerTable)
            ->select([
                "$customerTable.id",
                DB::raw("SUM($projectTable.value) as gross_value"),
                DB::raw("SUM($projectTable.cost) as cost"),
            ])
            ->join($projectTable, "$projectTable.customer_id", '=', "$customerTable.id");

        $this->applyFilters($query, $filters);

        return $query
            ->groupBy("$customerTable.id")
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
