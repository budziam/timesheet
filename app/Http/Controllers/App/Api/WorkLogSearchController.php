<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Models\WorkLog;
use App\Transformers\WorkLogFullcalendarTransformer;

class WorkLogSearchController extends BaseController
{
    public function fullcalendar()
    {
        $query = WorkLog::with('project')
            ->where('user_id', auth()->user()->id)
            ->whereDate('date', '>=', request('start'))
            ->whereDate('date', '<=', request('end'));

        return fractal()
            ->collection($query->get(), new WorkLogFullcalendarTransformer);
    }

    public function fullcalendarSync()
    {
        $query = WorkLog::where('user_id', auth()->user()->id)
            ->where('project_id', request('project_id'))
            ->whereDate('date', '>=', request('start'))
            ->whereDate('date', '<=', request('end'));

        return fractal()
            ->collection($query->get(), new WorkLogFullcalendarTransformer);
    }
}