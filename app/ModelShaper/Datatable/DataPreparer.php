<?php
namespace App\ModelShaper\Datatable;

class DataPreparer
{
    /** @var RequestDataStock */
    protected $requestDataStock;

    /** @var BaseDatatable */
    protected $datatable;

    public function __construct(RequestDataStock $requestHandler, BaseDatatable $datatable)
    {
        $this->requestDataStock = $requestHandler;
        $this->datatable = $datatable;
    }

    public function generate()
    {
        $this->datatable->initBuilder();
        $totalCount = $this->datatable
            ->getBuilder()
            ->getQuery()
            ->getCountForPagination();

        $this->datatable->filter(
            $this->requestDataStock->getSearch(),
            $this->requestDataStock->getColumns(),
            $this->requestDataStock->getFilters()
        );

        $filteredCount = $this->datatable
            ->getBuilder()
            ->getQuery()
            ->getCountForPagination();

        $this->datatable->order($this->requestDataStock->getOrder(), $this->requestDataStock->getColumns());
        $this->datatable->paginate($this->requestDataStock->getStart(), $this->requestDataStock->getLength());

        $models = $this->datatable->render();

        return [
            'totalCount'    => $totalCount,
            'filteredCount' => $filteredCount,
            'data'          => $models->all(),
        ];
    }
}
