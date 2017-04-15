<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Datatables\ProjectDatatable;
use App\Http\Requests\Dashboard\ProjectUpdateRequest;
use App\Models\Project;
use App\Transformers\Dashboard\ProjectTransformer;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\Datatable\DatatableFormRequest;

class ProjectController extends BaseController
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(new ProjectDatatable());

        return $shaper->shape($request);
    }

    public function show(Project $project)
    {
        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function update(Project $project, ProjectUpdateRequest $request)
    {
        $project->update($request->all());

        return $this->responseSuccess();
    }
}