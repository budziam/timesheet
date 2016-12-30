<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $componentData = [
            'workLogsSearchUrl'       => route('app.api.search.work-logs.fullcalendar'),
        ];

        return view('app.pages.home.index', compact('componentData'));
    }
}