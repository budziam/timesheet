<?php
namespace App\Services;

use App\Models\ProjectGroup;

class ProjectGroupSearchService
{
    /** @var SearchService */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @param string $search
     * @return \Eloquent
     */
    public function searchSelect2($search)
    {
        $query = ProjectGroup::query();

        $this->searchService
            ->filterQuery($query, 'name', $search);

        return $query;
    }
}