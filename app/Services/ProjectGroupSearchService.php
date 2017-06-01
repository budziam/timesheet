<?php
namespace App\Services;

use App\Models\ProjectGroup;
use ModelShaper\QueryUtils;

class ProjectGroupSearchService
{
    /**
     * @param string $search
     * @return \Eloquent
     */
    public function searchSelect2($search)
    {
        return ProjectGroup::query()
            ->where('name', 'LIKE', QueryUtils::valueForLike($search))
            ->latest('id');
    }
}