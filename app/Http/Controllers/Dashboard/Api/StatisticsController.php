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

class StatisticsController extends Controller
{
    public function projectWorkLogs(Project $project, WorkLogsStatistic $statistic)
    {
        return $statistic->get($project);
    }

    public function projectGroups(ProjectGroupsStatistic $statistic)
    {
        return $statistic->get();
    }

    public function customers(CustomersStatistic $statistic)
    {
        return $statistic->get();
    }
}