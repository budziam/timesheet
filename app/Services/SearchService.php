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
        $searchLike = '%' . implode('%', str_split($search)) . '%';

        return $query->where($column, 'LIKE', $searchLike)
            ->latest('id');
//        return $query
//            ->whereRaw("MATCH({$column}) AGAINST(?)", [$search])
//            ->orderByRaw("MATCH({$column}) AGAINST(?) DESC", [$search]);
    }
}