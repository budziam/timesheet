<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;
use App\Models\Project;

class WorkLogController extends BaseController
{
    public function create()
    {
        $componentData = [
            'projectsUrl'       => route('app.projects.index'),
            'projectsSearchUrl' => route('app.api.search.projects.select2'),
            'worklogsStoreUrl'  => route('app.api.work-logs.store'),
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