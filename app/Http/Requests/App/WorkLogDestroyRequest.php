<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;
use App\Models\WorkLog;

class WorkLogDestroyRequest extends BaseRequest
{
    public function beforeValidation()
    {
        /** @var WorkLog $workLog */
        $workLog = $this->workLog;

        WorkLog::where([
            'id'      => $workLog->id,
            'user_id' => $this->user()->id,
        ])
            ->firstOrFail();
    }
}