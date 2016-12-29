<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;
use App\Models\Project;

class WorkLogController extends BaseController
{
    public function index()
    {
        $componentData = [
            //
        ];

        return view('app.pages.work-logs.index', compact('componentData'));
    }

    public function sync()
    {
        $componentData = [
            'projectsUrl'             => route('app.projects.index'),
            'projectsSearchUrl'       => route('app.api.search.projects.select2'),
            'projectsWorklogsSyncUrl' => route('app.api.projects.work-logs.sync', ['[project]']),
        ];

        $this->injectProject($componentData);

        return view('app.pages.work-logs.create', compact('componentData'));
    }

    protected function injectProject(array &$componentData)
    {
        $project = Project::find(request('project_id'));

        if ($project !== null) {
            $componentData += [
                'projectSelected' => $project->id,
                'projectOptions'  => [
                    $project->id => $project->name,
                ],
            ];
        } else {
            $componentData += [
                'projectSelected' => null,
                'projectOptions'  => [],
            ];
        }
    }
}