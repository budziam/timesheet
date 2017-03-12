<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;

class ProjectController extends BaseController
{
    public function index()
    {
        return view('dashboard.pages.projects.index');
    }
}