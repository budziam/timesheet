<?php
namespace App\Services;

class SearchService
{
    /**
     * @param \Eloquent $query
     * @param string    $column
     * @param string    $search
     * @return \Eloquent
     */
    public function filterQuery($query, $column, $search)
    {
        if (strlen($search) < 4) {
            $searchLike = '%' . implode('%', str_split($search)) . '%';

            return $query->where($column, 'LIKE', $searchLike)
                ->latest('id');
        }

        return $query->whereRaw('MATCH(?) AGAINST(?)', [$column, $search])
            ->orderByRaw('MATCH(?) AGAINST(?) DESC', [$column, $search]);
    }
}