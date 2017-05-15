<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Models\Project;
use App\Transformers\ProjectTransformer;

class ProjectController extends BaseController
{
    public function show(Project $project)
    {
        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }
}