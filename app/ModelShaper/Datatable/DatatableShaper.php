<?php
namespace App\ModelShaper\Datatable;

class DatatableShaper
{
    /** @var BaseDatatable */
    protected $datatable;

    public function __construct(BaseDatatable $datatable)
    {
        $this->datatable = $datatable;
    }

    public function shape(DatatableFormRequest $request) : array
    {
        $requestHandler = new RequestDataStock($request);
        $dataPreparer = new DataPreparer($requestHandler, $this->datatable);

        $generated = $dataPreparer->generate();

        return [
            'draw'            => $requestHandler->getDraw(),
            'recordsTotal'    => $generated['totalCount'],
            'recordsFiltered' => $generated['filteredCount'],
            'data'            => $generated['data'],
        ];
    }
}
