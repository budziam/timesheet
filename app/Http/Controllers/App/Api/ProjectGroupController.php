<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Models\ProjectGroup;
use App\Transformers\ProjectGroupTransformer;

class ProjectGroupController extends BaseController
{
    public function index()
    {
        $groups = ProjectGroup::all();

        return fractal()
            ->collection($groups, new ProjectGroupTransformer);
    }
}