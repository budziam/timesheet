<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Datatables\ProjectGroupDatatable;
use App\Http\Requests\Dashboard\ProjectGroupStoreUpdateRequest;
use App\Models\ProjectGroup;
use App\Transformers\Dashboard\ProjectGroupTransformer;
use ModelShaper\Datatable\DatatableFormRequest;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\Select2\Select2FormRequest;
use ModelShaper\Select2\Select2Shaper;

class ProjectGroupController extends BaseController
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(ProjectGroupDatatable::make());

        return $shaper->shape($request);
    }

    public function select2(Select2FormRequest $request)
    {
        $shaper = new Select2Shaper(ProjectGroup::instance(), 'name');

        return $shaper->shape($request);
    }

    public function show(ProjectGroup $projectGroup)
    {
        return fractal()
            ->item($projectGroup, new ProjectGroupTransformer())
            ->toArray();
    }

    public function store(ProjectGroupStoreUpdateRequest $request)
    {
        $project = ProjectGroup::create($request->all());

        return fractal()
            ->item($project, new ProjectGroupTransformer())
            ->toArray();
    }

    public function update(ProjectGroupStoreUpdateRequest $request, ProjectGroup $projectGroup)
    {
        $projectGroup->update($request->all());

        return $this->responseSuccess();
    }

    public function destroy(ProjectGroup $projectGroup)
    {
        $projectGroup->delete();

        return $this->responseSuccess();
    }
}