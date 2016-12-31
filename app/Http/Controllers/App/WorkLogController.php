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
        $this->navbar->setActive('work-logs.sync');

        $componentData = [
            'projectsUrl'             => route('app.projects.index'),
            'projectsSearchUrl'       => route('app.api.search.projects.select2'),
            'projectsWorkLogsSyncUrl' => route('app.api.projects.work-logs.sync', ['~project~']),
            'workLogsSearchUrl'       => route('app.api.search.work-logs.fullcalendar-sync'),
        ];

        $this->injectProject($componentData);

        return view('app.pages.work-logs.sync', compact('componentData'));
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