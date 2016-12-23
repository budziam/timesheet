<?php
namespace App\Repositories;

use App\Models\ProjectGroup;
use App\Services\SearchService;

class ProjectGroupRepository
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
    public function searchModeSelect($search)
    {
        $query = ProjectGroup::query();

        $this->searchService
            ->filterQuery($query, 'name', $search);

        return $query;
    }
}