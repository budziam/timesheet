<?php
namespace App\Http\Controllers\App;

use App\Bases\Controller;

class WorkLogController extends Controller
{
    public function sync()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Manage work logs'), route('app.work-logs.sync'));
        $this->navbarBuilder->setActive('work-logs.sync');

        return view('app.pages.work-logs.sync');
    }
}