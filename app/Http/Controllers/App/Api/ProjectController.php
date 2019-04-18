<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\Controller;
use App\Models\Project;
use App\Transformers\ProjectTransformer;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }
}
