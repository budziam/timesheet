<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseDashboardController;

class StatisticsController extends BaseDashboardController
{
    public function projects()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Projects'), route('dashboard.statistics.projects'));
        $this->navbarBuilder->setActive('statistics-projects');

        return view('dashboard.pages.statistics.projects');
    }

    public function projectGroups()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Project groups'), route('dashboard.statistics.project-groups'));
        $this->navbarBuilder->setActive('statistics-project-groups');

        return view('dashboard.pages.statistics.project-groups');
    }
}