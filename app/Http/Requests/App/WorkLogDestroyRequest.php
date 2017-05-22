<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;
use App\Models\WorkLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkLogDestroyRequest extends BaseRequest
{
    public function beforeValidation()
    {
        /** @var WorkLog $workLog */
        $workLog = $this->workLog;

        $workLog2 = WorkLog::where([
            'id'      => $workLog->id,
            'user_id' => $this->user()->id,
        ])
            ->firstOrFail();

        if (!$workLog2->editable) {
            throw (new ModelNotFoundException)->setModel(static::class);
        }
    }
}