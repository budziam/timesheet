<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectIndexRequest;
use App\Models\Project;
use App\Transformers\ProjectTransformer;

class ProjectController extends BaseController
{
    public function index(ProjectIndexRequest $request)
    {
        $search = $request->input('search', '');

        $projects = Project::with('groups')
            ->whereRaw('MATCH(name) AGAINST(?) > -1', [$search])
            ->orderByRaw('MATCH(name) AGAINST(?) DESC', [$search])
            ->get();

        return fractal()
            ->collection($projects, new ProjectTransformer);
    }
}