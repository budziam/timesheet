<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Datatables\WorkLogDatatable;
use App\Http\Requests\Dashboard\WorkLogStoreUpdateRequest;
use App\Models\WorkLog;
use App\Transformers\Dashboard\WorkLogTransformer;
use ModelShaper\Datatable\DatatableFormRequest;
use ModelShaper\Datatable\DatatableShaper;

class WorkLogController extends BaseController
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(app(WorkLogDatatable::class));

        return $shaper->shape($request);
    }

    public function show(WorkLog $workLog)
    {
        return fractal()
            ->item($workLog, new WorkLogTransformer())
            ->toArray();
    }

    public function store(WorkLogStoreUpdateRequest $request)
    {
        $workLog = WorkLog::create($request->all());

        return fractal()
            ->item($workLog, new WorkLogTransformer())
            ->toArray();
    }

    public function update(WorkLog $workLog, WorkLogStoreUpdateRequest $request)
    {
        $workLog->update($request->all());

        return $this->responseSuccess();
    }

    public function destroy(WorkLog $workLog)
    {
        $workLog->delete();

        return $this->responseSuccess();
    }
}