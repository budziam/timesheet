<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\DashboardController;

class StatisticsController extends DashboardController
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

    public function customers()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Statistics: Customers'), route('dashboard.statistics.customers'));
        $this->navbarBuilder->setActive('statistics-customers');

        return view('dashboard.pages.statistics.customers');
    }
}