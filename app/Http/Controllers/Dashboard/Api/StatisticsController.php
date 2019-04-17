<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use App\Statistics\CustomersStatistic;
use App\Statistics\ProjectGroupsStatistic;
use App\Statistics\WorkLogsStatistic;
use DB;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function projectWorkLogs(Project $project, WorkLogsStatistic $statistic)
    {
        return $statistic->get($project);
    }

    public function projectGroups(Request $request, ProjectGroupsStatistic $statistic)
    {
        return $statistic->get($request->all());
    }

    public function customers(CustomersStatistic $statistic)
    {
        return $statistic->get();
    }
}
