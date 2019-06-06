<?php
namespace App\ModelShaper\Datatable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use App\ModelShaper\QueryUtils;

abstract class BaseDatatable
{
    /** @var Builder */
    protected $builder;

    abstract public function initBuilder();

    abstract public function render() : Collection;

    public function getBuilder()
    {
        return clone $this->builder;
    }

    public function paginate(int $offset, int $limit)
    {
        $this->builder->offset($offset)->limit($limit);
    }

    public function filter(array $search, array $columns, array $filters)
    {
        $filterableColumns = $this->getFilterableColumns($columns);

        $q = data_get($search, 'value');
        $this->builder->whereNested(function ($query) use ($filterableColumns, $q) {
            foreach ($filterableColumns as $column) {
                $columnName = $this->getColumnName($column);

                $query->whereNested(function ($query) use ($columnName, $q) {
                    $this->filterByColumn($query, $columnName, $q);
                }, 'or');
            }
        });

        $this->builder->whereNested(function ($query) use ($filterableColumns) {
            foreach ($filterableColumns as $column) {
                $columnName = $this->getColumnName($column);
                $q = data_get($column, 'search.value');

                $this->filterByColumn($query, $columnName, $q);
            }
        });

        $this->builder->whereNested(function ($query) use ($filters) {
            $this->filterByFilters($query, $filters);
        });
    }

    public function order(array $order, array $columns)
    {
        foreach ($order as $item) {
            $columnId = $item['column'];
            $column = $columns[$columnId];

            if (!data_get($column, 'orderable', false)) {
                continue;
            }

            $columnName = $this->getColumnName($column);
            $order = $item['dir'];

            $this->orderByColumn($this->builder, $columnName, $order);
        }
    }

    protected function orderByColumn($query, string $column, string $order)
    {
        $method = 'orderBy' . studly_case($column);
        if (method_exists($this, $method)) {
            $this->$method($query, $order);
            return;
        }

        $query->orderBy($this->columnWithTable($column), $order);
    }

    protected function filterByColumn($query, string $column, string $search)
    {
        $search = strtolower(trim($search));
        if (!strlen($search)) {
            return;
        }

        $method = 'filterBy' . studly_case($column);
        if (method_exists($this, $method)) {
            $this->$method($query, $search);
            return;
        }

        $query->where($this->columnWithTable($column), 'LIKE', QueryUtils::valueForLike($search));
    }

    protected function filterByFilters($query, array $filters)
    {
        //
    }

    protected function getFilterableColumns(array $columns) : Collection
    {
        return collect($columns)
            ->filter(function (array $column) {
                return QueryUtils::isTrue(data_get($column, 'searchable'));
            });
    }

    protected function getColumnName(array $column) : string
    {
        return isset($column['name']) && strlen($column['name']) ? $column['name'] : $column['data'];
    }

    protected function columnWithTable(string $column) : string
    {
        $table = $this->builder->getQuery()->from;

        return $table . '.' . $column;
    }
}
