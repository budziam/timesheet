<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectWorkLogStoreRequest;
use App\Models\Project;
use App\Models\WorkLog;

class ProjectWorkLogController extends BaseController
{
    public function store(Project $project, ProjectWorkLogStoreRequest $request)
    {
        $workLog = WorkLog::create([
            'user_id'        => $this->user()->id,
            'project_id'     => $project->id,
            'date'           => $request->get('date'),
            'time_fieldwork' => $request->get('time_fieldwork'),
            'time_office'    => $request->get('time_office'),
            'comment'        => $request->get('comment'),
        ]);

        return $this->responseSuccess($workLog->toArray());
    }
}