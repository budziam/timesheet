<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\BaseController;
use App\Datatables\ProjectDatatable;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\Datatable\DatatableFormRequest;

class ProjectController extends BaseController
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(new ProjectDatatable());

        return $shaper->shape($request);
    }
}