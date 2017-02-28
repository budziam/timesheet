<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;
use App\Models\Project;

class WorkLogController extends BaseController
{
    public function index()
    {
        return view('app.pages.work-logs.index');
    }

    public function sync()
    {
        $this->navbar->setActive('work-logs.sync');

        $componentData = $this->getProjectDetails();

        return view('app.pages.work-logs.sync', compact('componentData'));
    }

    protected function getProjectDetails() : array
    {
        $project = Project::find(request('project_id'));

        if ($project !== null) {
            return [
                'projectSelected' => $project->id,
                'projectOptions'  => [
                    $project->id => $project->name,
                ],
            ];
        }

        return [
            'projectSelected' => null,
            'projectOptions'  => [],
        ];
    }
}