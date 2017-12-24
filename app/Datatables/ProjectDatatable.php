<?php
namespace App\Datatables;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Utils\DateUtils;
use DB;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\BaseDatatable;

class ProjectDatatable extends BaseDatatable
{
    /** @var ProjectRepository */
    protected $projectRepository;

    /** @var bool */
    protected $onlyActive = false;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function initBuilder()
    {
        $this->builder = Project::query();
    }

    public function filter(array $search, array $columns)
    {
        parent::filter($search, $columns);

        if ($this->onlyActive) {
            $this->builder->whereNull('ends_at');
        }
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (Project $project) {
                return [
                    'id'      => [
                        'display' => $this->projectRepository->getLink($project, '#' . $project->id),
                        'raw'     => $project->id,
                    ],
                    'lkz'     => $project->lkz,
                    'kerg'    => $project->kerg,
                    'name'    => $project->name,
                    'ends_at' => DateUtils::formatEndsAt($project->ends_at),
                ];
            });
    }

    public function onlyActive(bool $value)
    {
        $this->onlyActive = $value;
    }

    protected function orderByEndsAt($query, string $order)
    {
        $query->orderBy(DB::raw('ends_at IS NULL'), $order);
        $query->orderBy('ends_at', $order);
    }
}