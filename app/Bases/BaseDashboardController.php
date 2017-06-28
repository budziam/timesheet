<?php
namespace App\Bases;

class BaseDashboardController extends BaseController
{
    protected function preInitPageInformation()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Dashboard'), route('dashboard.home.index'));

        parent::preInitPageInformation();
    }
}
