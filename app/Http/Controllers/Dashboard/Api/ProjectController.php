<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Models\Project;

class ProjectController extends BaseController
{
    public function datatable()
    {
        return Project::all();
    }
}