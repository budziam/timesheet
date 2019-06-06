<?php
namespace App\ModelShaper\Datatable;

class RequestDataStock
{
    /**
     * Draw counter. This is used by DataTables to ensure that the
     * Ajax returns from server-side processing requests are drawn in
     * sequence by DataTables (Ajax requests are asynchronous and
     * thus can return out of sequence). This is used as part of the
     * draw return parameter.
     *
     * @var int
     */
    protected $draw;

    /**
     * Paging first record indicator. This is the start point in the
     * current data set (0 index based - i.e. 0 is the first record).
     *
     * @var int
     */
    protected $start;

    /**
     * Number of records that the table can display in the current draw.
     * It is expected that the number of records returned will be equal
     * to this number, unless the server has fewer records to return.
     * Note that this can be -1 to indicate that all records should be
     * returned (although that negates any benefits of server-side processing!)
     *
     * @var int
     */
    protected $length;

    /**
     * [value] : string - Global search value. To be applied to all columns
     * which have searchable as true.
     *
     * [regex] : boolean - true if the global filter should be treated as a regular
     * expression for advanced searching, false otherwise. Note that
     * normally server-side processing scripts will not perform regular
     * expression searching for performance reasons on large data sets,
     * but it is technically possible and at the discretion of your script.
     *
     * @var array
     */
    protected $search;

    /**
     * [i][column] : integer - Column to which ordering should be applied.
     * This is an index reference to the columns array of information that
     * is also submitted to the server.
     *
     * [i][dir] : string - Ordering direction for this column. It will be
     * asc or desc to indicate ascending ordering or descending ordering,
     * respectively.
     *
     * @var array
     */
    protected $order;

    /**
     * [i][data] : string - Column's data source, as defined by columns.data
     *
     * [i][name] : string - Column's name, as defined by columns.name
     *
     * [i][searchable] : boolean - Flag to indicate if this column is
     * searchable (true) or not (false). This is controlled by columns.searchable.
     *
     * [i][orderable] : boolean - Flag to indicate if this column is
     * orderable (true) or not (false). This is controlled
     * by columns.orderable
     *
     * [i][search][value] : string - Search value to apply to
     * this specific column.
     *
     * [i][search][regex] : boolean - Flag to indicate if the search
     * term for this column should be treated as regular expression (true)
     * or not (false). As with global search, normally server-side processing
     * scripts will not perform regular expression searching for performance
     * reasons on large data sets, but it is technically possible and at
     * the discretion of your script.
     *
     * @var array
     */
    protected $columns;

    public function __construct(DatatableFormRequest $request)
    {
        $this->parseRequestData($request);
    }

    /**
     * Parses request data and puts it into appropriate properties
     *
     * @param DatatableFormRequest $request
     */
    protected function parseRequestData(DatatableFormRequest $request)
    {
        $this->draw = (int)$request->input('draw');
        $this->start = (int)$request->input('start');
        $this->length = (int)$request->input('length');
        $this->search = (array)$request->input('search');
        $this->order = (array)$request->input('order');
        $this->columns = (array)$request->input('columns');
        $this->filters = (array)$request->input('filters');
    }

    public function getDraw() : int
    {
        return $this->draw;
    }

    public function getColumns() : array
    {
        return $this->columns;
    }

    public function getFilters() : array
    {
        return $this->filters;
    }

    public function getOrder() : array
    {
        return $this->order;
    }

    public function getSearch() : array
    {
        return $this->search;
    }

    public function getStart() : int
    {
        return $this->start;
    }

    public function getLength() : int
    {
        return $this->length;
    }
}
