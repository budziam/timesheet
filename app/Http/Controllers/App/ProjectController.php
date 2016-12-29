<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class ProjectController extends BaseController
{
    public function index()
    {
        $componentData = [
            'projectsUrl'      => route('app.api.search.projects.default'),
            'projectGroupsUrl' => route('app.api.search.project-groups.select2'),
            'workLogUrl'       => route('app.work-logs.sync'),
        ];

        return view('app.pages.projects.index', compact('componentData'));
    }
}