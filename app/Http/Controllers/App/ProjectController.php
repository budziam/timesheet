<?php
namespace App\Http\Controllers\App;

use App\Bases\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Projects'), route('app.projects.index'));
        $this->navbarBuilder->setActive('projects');

        return view('app.pages.projects.index');
    }
}