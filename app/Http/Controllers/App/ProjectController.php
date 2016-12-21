<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class ProjectController extends BaseController
{
    public function index()
    {
        $componentData = [
            'projectsUrl' => route('app.api.projects.index'),
        ];

        return view('app.pages.projects.index', compact('componentData'));
    }
}