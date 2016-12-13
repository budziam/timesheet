<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('groups')
            ->get();
    }
}