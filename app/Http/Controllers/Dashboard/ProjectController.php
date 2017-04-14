<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;
use App\Models\Project;

class ProjectController extends BaseController
{
    public function index()
    {
        return view('dashboard.pages.projects.index');
    }

    public function show(Project $project)
    {
        return view('dashboard.pages.projects.show', compact('project'));
    }
}
