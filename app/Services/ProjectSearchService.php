<?php
namespace App\Services;

use App\Models\Project;
use ModelShaper\QueryUtils;

class ProjectSearchService
{
    /**
     * @param string $search
     * @param array  $groups
     * @return \Illuminate\Database\Eloquent\Collection|Project[]
     */
    public function searchDefault(string $search, array $groups = [])
    {
        $query = Project::with('groups', 'customer')
            ->active()
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', QueryUtils::valueForLike($search))
                    ->orWhere('lkz', 'LIKE', QueryUtils::valueForLike($search))
                    ->orWhere('kerg', 'LIKE', QueryUtils::valueForLike($search));
            })
            ->latest('id');

        if (count($groups)) {
            $query->whereHas('groups', function ($query) use ($groups) {
                $query->whereIn('id', $groups);
            });
        }

        return $query->get();
    }

    public function searchSelect2(string $search)
    {
        return Project::query()
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', QueryUtils::valueForLike($search))
                    ->orWhere('lkz', 'LIKE', QueryUtils::valueForLike($search))
                    ->orWhere('kerg', 'LIKE', QueryUtils::valueForLike($search));
            })
            ->latest('id');
    }
}
