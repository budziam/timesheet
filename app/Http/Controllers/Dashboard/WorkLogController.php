<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;

class WorkLogController extends BaseController
{
    public function index()
    {
        return view('dashboard.pages.work-logs.index');
    }
}