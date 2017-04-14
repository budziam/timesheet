<?php
namespace App\Datatables;

use App\Models\Project;
use App\Utils\DateUtils;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\DatatableContract;
use ModelShaper\Datatable\Traits\FilterTrait;
use ModelShaper\Datatable\Traits\SortTrait;

class ProjectDatatable implements DatatableContract
{
    use FilterTrait, SortTrait;

    public function render() : Collection
    {
        return Project::all()
            ->map(function (Project $project) {
                $link = (string)link_to_route(
                    'dashboard.projects.show', '#' . $project->id, $project->getRouteKey(), ['target' => '_blank']
                );

                return [
                    'id'      => [
                        'display'  => $link,
                        'raw'      => $project->id,
                        'routeKey' => $project->getRouteKey(),
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