<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\WorkLogUpdateRequest;
use App\Models\Project;
use App\Models\WorkLog;

class ProjectController extends BaseController
{
    public function show(Project $project)
    {
        return $project;
    }
}