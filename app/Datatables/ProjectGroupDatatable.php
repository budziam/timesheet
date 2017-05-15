<?php
namespace App\Datatables;

use App\Models\ProjectGroup;
use App\Repositories\ProjectGroupRepository;
use App\Traits\Instantiable;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\DatatableContract;
use ModelShaper\Datatable\Traits\FilterTrait;
use ModelShaper\Datatable\Traits\SortTrait;

class ProjectGroupDatatable implements DatatableContract
{
    use FilterTrait, SortTrait, Instantiable;

    /** @var ProjectGroupRepository */
    protected $repository;

    public function __construct(ProjectGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function render() : Collection
    {
        return ProjectGroup::all()
            ->map(function (ProjectGroup $projectGroup) {
                return [
                    'id'      => [
                        'display' => $this->repository->getLink($projectGroup, '#' . $projectGroup->id),
                        'raw'     => $projectGroup->id,
                    ],
                    'name'    => $projectGroup->name,
                ];
            });
    }
}