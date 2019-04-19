<?php
namespace App\Services;

use App\Models\Project;
use App\Models\ProjectGroup;
use DB;

class ProjectFilterService
{
    public function filterByYear($query, array $filters)
    {
        $projectTable = Project::table();

        if (array_has($filters, 'start_years')) {
            $query->whereIn(DB::raw("YEAR({$projectTable}.created_at)"), $filters['start_years']);
        }

        if (array_has($filters, 'end_years')) {
            $query->whereIn(DB::raw("YEAR({$projectTable}.ends_at)"), $filters['end_years']);
        }
    }

    public function filterByOnlyCompleted($query, array $filters)
    {
        $projectTable = Project::table();

        if (array_get($filters, "only_completed")) {
            $query->whereNotNull("$projectTable.ends_at");
        }
    }

    public function filterByOnlyActive($query, array $filters)
    {
        $projectTable = Project::table();

        if (array_get($filters, "only_active")) {
            $query->whereNull("$projectTable.ends_at");
        }
    }

    public function filterByCustomer($query, array $filters)
    {
        $projectTable = Project::table();

        $customers = (array)array_get($filters, "customers");
        if (!empty($customers)) {
            $query->whereIn("$projectTable.customer_id", $customers);
        }
    }

    public function filterByGroups($query, array $filters)
    {
        $projectGroupTable = ProjectGroup::table();

        $groups = (array)array_get($filters, "project_groups");
        if (!empty($groups)) {
            $query->whereIn("$projectGroupTable.id", $groups);
        }
    }
}
