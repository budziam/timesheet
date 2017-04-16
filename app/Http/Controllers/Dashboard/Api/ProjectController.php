<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Datatables\ProjectDatatable;
use App\Http\Requests\Dashboard\ProjectDestroyRequest;
use App\Http\Requests\Dashboard\ProjectStoreUpdateRequest;
use App\Models\Project;
use App\Transformers\Dashboard\ProjectTransformer;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\Datatable\DatatableFormRequest;

class ProjectController extends BaseController
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(ProjectDatatable::make());

        return $shaper->shape($request);
    }

    public function show(Project $project)
    {
        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function store(ProjectStoreUpdateRequest $request)
    {
        $project = Project::create($request->all());

        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function update(Project $project, ProjectStoreUpdateRequest $request)
    {
        $project->update($request->all());

        return $this->responseSuccess();
    }

    public function destroy(Project $project, ProjectDestroyRequest $request)
    {
        $project->delete();

        return $this->responseSuccess();
    }
}