<?php
namespace App\Datatables;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Services\ProjectFilterService;
use App\Utils\DateUtils;
use DB;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\BaseDatatable;

class ProjectDatatable extends BaseDatatable
{
    /** @var ProjectRepository */
    private $projectRepository;

    /** @var ProjectFilterService */
    private $projectFilterService;

    public function __construct(
        ProjectRepository $projectRepository,
        ProjectFilterService $projectFilterService
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectFilterService = $projectFilterService;
    }

    public function initBuilder()
    {
        $this->builder = Project::query();
    }

    protected function filterByFilters($query, array $filters)
    {
        if (array_get($filters, "only_active")) {
            $query->whereNull('ends_at');
        }

        $this->projectFilterService->filterByYear($query, $filters);
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (Project $project) {
                return [
                    'id'      => [
                        'display' => $this->projectRepository->getLink($project,
                            '#' . $project->id),
                        'raw'     => $project->id,
                    ],
                    'lkz'     => $project->lkz,
                    'kerg'    => $project->kerg,
                    'name'    => $project->name,
                    'ends_at' => DateUtils::formatEndsAt($project->ends_at),
                ];
            });
    }

    protected function orderByEndsAt($query, string $order)
    {
        $query->orderBy(DB::raw('ends_at IS NULL'), $order);
        $query->orderBy('ends_at', $order);
    }
}
