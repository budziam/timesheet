<?php
namespace App\Datatables;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Traits\Instantiable;
use App\Utils\DateUtils;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\DatatableContract;
use ModelShaper\Datatable\Traits\FilterTrait;
use ModelShaper\Datatable\Traits\SortTrait;

class ProjectDatatable implements DatatableContract
{
    use FilterTrait, SortTrait, Instantiable;

    /** @var ProjectRepository */
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function render() : Collection
    {
        return Project::all()
            ->map(function (Project $project) {
                return [
                    'id'      => [
                        'display' => $this->projectRepository->getLink($project, '#' . $project->id),
                        'raw'     => $project->id,
                    ],
                    'name'    => $project->name,
                    'ends_at' => [
                        'display' => DateUtils::formatEndsAt($project->ends_at),
                        'sort'    => data_get($project->ends_at, 'timestamp', PHP_INT_MAX),
                    ],
                ];
            });
    }
}