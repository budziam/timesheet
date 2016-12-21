<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Models\Project;

class ProjectController extends BaseController
{
    public function index()
    {
        $projects = Project::with('groups')
            ->get();

        return $projects;
    }
}