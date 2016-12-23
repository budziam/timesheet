<?php
namespace App\Repositories;

use App\Models\Project;
use App\Services\SearchService;

class ProjectRepository
{
    /** @var SearchService */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @param string $search
     * @param array  $groups
     * @return \Illuminate\Database\Eloquent\Collection|Project[]
     */
    public function search($search, array $groups = [])
    {
        $query = Project::with('groups')
            ->active();

        $this->searchService
            ->filterQuery($query, 'name', $search);

        if (count($groups)) {
            $query->whereHas('groups', function ($query) use ($groups) {
                $query->whereIn('id', $groups);
            });
        }

        return $query->get();
    }
}