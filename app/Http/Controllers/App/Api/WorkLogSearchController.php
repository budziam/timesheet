<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Models\WorkLog;
use App\Transformers\WorkLogFullcalendarTransformer;

class WorkLogSearchController extends BaseController
{
    public function fullcalendar()
    {
        $query = WorkLog::where('user_id', auth()->user()->id)
            ->whereDate('date', '>=', request('start'))
            ->whereDate('date', '<=', request('end'))
            ->orderBy('date')
            ->orderBy('type', 'desc');

        if (request()->exists('project_id')) {
            $query->where('project_id', request('project_id'));
        }

        return fractal()
            ->collection($query->get(), new WorkLogFullcalendarTransformer);
    }
}