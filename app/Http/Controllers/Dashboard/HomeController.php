<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;

class HomeController extends BaseController
{
    protected function initPageInformation()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Homepage'), route('dashboard.home.index'));
    }

    public function index()
    {
        return view('dashboard.pages.home.index');
    }
}