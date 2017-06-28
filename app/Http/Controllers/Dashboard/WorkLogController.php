<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseDashboardController;
use App\Models\WorkLog;

class WorkLogController extends BaseDashboardController
{
    protected function initPageInformation()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Work Logs'), route('dashboard.work-logs.index'));
        $this->navbarBuilder->setActive('work-logs');
    }

    public function index()
    {
        return view('dashboard.pages.work-logs.index');
    }

    public function edit(WorkLog $workLog)
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb($workLog->id, route('dashboard.work-logs.edit', $workLog->getRouteKey()));

        return view('dashboard.pages.work-logs.edit', compact('workLog'));
    }

    public function create()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Create'), route('dashboard.work-logs.create'));

        return view('dashboard.pages.work-logs.create');
    }
}