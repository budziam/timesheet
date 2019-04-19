<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\DashboardController;
use App\Models\Project;

class StatisticsController extends DashboardController
{
    public function projects(Project $project = null)
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Projects'), route('dashboard.statistics.projects'));
        $this->navbarBuilder->setActive('statistics-projects');

        $projectId = $project->id ?? null;
        $projectName = $project->name ?? null;

        return view('dashboard.pages.statistics.projects', compact("projectId", "projectName"));
    }

    public function projectGroups()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Project groups'), route('dashboard.statistics.project-groups'));
        $this->navbarBuilder->setActive('statistics-project-groups');

        return view('dashboard.pages.statistics.project-groups');
    }

    public function customers()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Customers'), route('dashboard.statistics.customers'));
        $this->navbarBuilder->setActive('statistics-customers');

        return view('dashboard.pages.statistics.customers');
    }
}
