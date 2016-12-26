<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\WorkLogStoreRequest;
use App\Repositories\WorkLogRepository;

class WorkLogController extends BaseController
{
    public function store(WorkLogStoreRequest $request, WorkLogRepository $repository)
    {
        return $this->responseSuccess();

        $repository->create(auth()->user(), $request->project, $request->allTransformed());

        return $this->responseSuccess();
    }
}