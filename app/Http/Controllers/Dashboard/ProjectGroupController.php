<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;
use App\Models\ProjectGroup;

class ProjectGroupController extends BaseController
{
    protected function initPageInformation()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(
            __('Project groups'), route('dashboard.project-groups.index')
        );
    }

    public function index()
    {
        return view('dashboard.pages.project-groups.index');
    }

    public function edit(ProjectGroup $projectGroup)
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(
                $projectGroup->name, route('dashboard.project-groups.edit', $projectGroup->getRouteKey())
            );

        return view('dashboard.pages.project-groups.edit', compact('projectGroup'));
    }

    public function create()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Create'), route('dashboard.project-groups.create'));

        return view('dashboard.pages.project-groups.create');
    }
}
