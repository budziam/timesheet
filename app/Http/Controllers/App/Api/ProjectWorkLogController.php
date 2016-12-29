<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\WorkLogSyncRequest;
use App\Models\Project;
use App\Repositories\WorkLogRepository;

class ProjectWorkLogController extends BaseController
{
    public function sync(Project $project, WorkLogSyncRequest $request, WorkLogRepository $repository)
    {
        $repository->sync(
            auth()->user(), $project,
            $request->input('work_logs'), $request->input('date_from'), $request->input('date_to')
        );

        return $this->responseSuccess();
    }
}