<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class WorkLogController extends BaseController
{
    public function create()
    {
        $componentData = [
            'projectsUrl' => route('app.api.search.projects.select2'),
        ];

        return view('app.pages.work-logs.create', compact('componentData'));
    }
}