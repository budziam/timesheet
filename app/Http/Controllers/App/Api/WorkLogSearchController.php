<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\Controller;
use App\Models\WorkLog;
use App\Transformers\WorkLogFullcalendarTransformer;
use Illuminate\Http\Request;

class WorkLogSearchController extends Controller
{
    public function fullcalendar(Request $request)
    {
        $query = WorkLog::with('project')
            ->where('user_id', auth()->user()->id)
            ->whereDate('date', '>=', $request->input('start'))
            ->whereDate('date', '<=', $request->input('end'));

        return fractal()
            ->collection($query->get(), new WorkLogFullcalendarTransformer);
    }

    public function fullcalendarSync(Request $request)
    {
        $query = WorkLog::with('project')
            ->where('user_id', auth()->user()->id)
            ->where('project_id', $request->input('project_id'))
            ->whereDate('date', '>=', $request->input('start'))
            ->whereDate('date', '<=', $request->input('end'));

        return fractal()
            ->collection($query->get(), new WorkLogFullcalendarTransformer);
    }
}