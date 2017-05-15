<?php
namespace App\Services;

use App\Models\Project;

class ProjectSearchService
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
    public function searchDefault($search, array $groups = [])
    {
        $query = Project::with('groups')->active();

        $this->searchService
            ->filterQuery($query, 'name', $search);

        if (count($groups)) {
            $query->whereHas('groups', function ($query) use ($groups) {
                $query->whereIn('id', $groups);
            });
        }

        return $query->get();
    }

    /**
     * @param string $search
     * @return \Eloquent
     */
    public function searchSelect2($search)
    {
        $query = Project::query();

        $this->searchService
            ->filterQuery($query, 'name', $search);

        return $query;
    }
}