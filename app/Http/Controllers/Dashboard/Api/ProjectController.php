<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\Controller;
use App\Datatables\ProjectDatatable;
use App\Http\Requests\Dashboard\ProjectDestroyRequest;
use App\Http\Requests\Dashboard\ProjectStoreUpdateRequest;
use App\Models\Project;
use App\Transformers\Dashboard\ProjectTransformer;
use App\Transformers\ProjectSelect2Transformer;
use ModelShaper\Datatable\DatatableFormRequest;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\QueryUtils;
use ModelShaper\Select2\Select2FormRequest;
use ModelShaper\Select2\Select2Shaper;

class ProjectController extends Controller
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(app(ProjectDatatable::class));

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

    public function store(ProjectStoreUpdateRequest $request)
    {
        $project = Project::create($request->all());
        $project->groups()->sync($request->input('groups', []));

        return fractal()
            ->item($project, new ProjectTransformer())
            ->toArray();
    }

    public function update(ProjectStoreUpdateRequest $request, Project $project)
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