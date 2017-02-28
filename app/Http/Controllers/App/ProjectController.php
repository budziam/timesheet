<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class ProjectController extends BaseController
{
    public function index()
    {
        $this->navbar->setActive('projects');

        return view('app.pages.projects.index');
    }
}