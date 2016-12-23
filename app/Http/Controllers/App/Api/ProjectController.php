<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectIndexRequest;
use App\Repositories\ProjectRepository;
use App\Transformers\ProjectTransformer;

class ProjectController extends BaseController
{
    public function index(ProjectIndexRequest $request, ProjectRepository $repository)
    {
        $search = $request->input('search', '');
        $groups = $request->input('groups', []);

        $projects = $repository->search($search, $groups);

        return fractal()
            ->collection($projects, new ProjectTransformer);
    }
}