<?php
namespace App\Bases;

class DashboardController extends Controller
{
    protected function preInitPageInformation()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Dashboard'), route('dashboard.home.index'));

        parent::preInitPageInformation();
    }
}
