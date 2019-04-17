<?php
namespace App\Services;


use App\Models\Project;
use DB;

class ProjectFilterService
{
    public function filterByYear($query, array $filters)
    {
        $pTable = Project::table();

        if (array_has($filters, 'start_years')) {
            $query->whereIn(DB::raw("YEAR({$pTable}.created_at)"), $filters['start_years']);
        }

        if (array_has($filters, 'end_years')) {
            $query->whereIn(DB::raw("YEAR({$pTable}.ends_at)"), $filters['end_years']);
        }
    }

    public function filterByOnlyCompleted($query, array $filters)
    {
        $projectTable = Project::table();

        if (array_get($filters, "only_completed")) {
            $query->whereNotNull("$projectTable.ends_at");
        }
    }
}
