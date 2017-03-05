<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\WorkLogDestroyRequest;
use App\Http\Requests\App\WorkLogUpdateRequest;
use App\Models\WorkLog;

class WorkLogController extends BaseController
{
    public function update(WorkLog $workLog, WorkLogUpdateRequest $request)
    {
        $workLog->update([
            'time_fieldwork' => $request->get('time_fieldwork'),
            'time_office'    => $request->get('time_office'),
        ]);

        return $this->responseSuccess();
    }

    public function destroy(WorkLog $workLog, WorkLogDestroyRequest $request)
    {
        $workLog->delete();

        return $this->responseSuccess();
    }
}
