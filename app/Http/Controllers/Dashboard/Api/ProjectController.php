<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\Controller;
use App\Datatables\ProjectDatatable;
use App\Http\Requests\Dashboard\ProjectDatatableRequest;
use App\Http\Requests\Dashboard\ProjectDestroyRequest;
use App\Http\Requests\Dashboard\ProjectStoreRequest;
use App\Http\Requests\Dashboard\ProjectUpdateRequest;
use App\Models\Project;
use App\Transformers\Dashboard\ProjectTransformer;
use App\Transformers\ProjectSelect2Transformer;
use App\ModelShaper\Datatable\DatatableShaper;
use App\ModelShaper\QueryUtils;
use App\ModelShaper\Select2\Select2FormRequest;
use App\ModelShaper\Select2\Select2Shaper;

class ProjectController extends Controller
{
    public function datatable(ProjectDatatableRequest $request, ProjectDatatable $datatable)
    {
        $shaper = new DatatableShaper($datatable);

        return $shaper->shape($request);
    }

    public function select2(Select2FormRequest $request)
    {
        $shaper = new Select2Shaper(Project::instance(), 'name');
        $shaper->setTransformer(new ProjectSelect2Transformer());
        $shaper->setQueryModifier(function ($query, Select2FormRequest $request) {
            $search = (string)$request->input('q');

            $query->orWhere('lkz', 'LIKE', QueryUtils::valueForLike($search))
                ->orWhere('kerg', 'LIKE', QueryUtils::valueForLike($search));
        });

        return $shaper->shape($request);
    }

    public function show(Project $project)
    {
        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function store(ProjectStoreRequest $request)
    {
        $project = Project::create($request->all());
        $project->groups()->sync($request->input('groups', []));

        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->all());
        $project->groups()->sync($request->input('groups', []));

        return $this->responseSuccess();
    }

    public function destroy(Project $project, ProjectDestroyRequest $request)
    {
        $project->delete();

        return $this->responseSuccess();
    }

    public function complete(Project $project)
    {
        $project->complete();

        return $this->responseSuccess();
    }
}
