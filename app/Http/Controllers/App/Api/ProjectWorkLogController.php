<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\WorkLogSyncRequest;
use App\Models\Project;
use App\Models\WorkLog;
use App\Repositories\WorkLogRepository;
use App\Transformers\WorkLogTransformer;

class ProjectWorkLogController extends BaseController
{
    public function index(Project $project)
    {
        $workLogs = WorkLog::where([
            'project_id' => $project->id,
            'user_id'    => auth()->user()->id,
        ])
            ->get();

        return fractal()
            ->collection($workLogs, new WorkLogTransformer);
    }

    public function sync(Project $project, WorkLogSyncRequest $request, WorkLogRepository $repository)
    {
        $repository->sync(
            auth()->user(), $project,
            $request->input('work_logs'), $request->input('date_from'), $request->input('date_to')
        );

        return $this->responseSuccess();
    }
}