<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class WorkLogController extends BaseController
{
    public function sync()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Manage work logs'), route('app.work-logs.sync'));
        $this->navbarBuilder->setActive('work-logs.sync');

        return view('app.pages.work-logs.sync');
    }
}