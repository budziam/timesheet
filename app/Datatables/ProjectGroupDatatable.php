<?php
namespace App\Datatables;

use App\Models\ProjectGroup;
use App\Repositories\ProjectGroupRepository;
use Illuminate\Support\Collection;
use App\ModelShaper\Datatable\BaseDatatable;

class ProjectGroupDatatable extends BaseDatatable
{
    /** @var ProjectGroupRepository */
    protected $repository;

    public function __construct(ProjectGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function initBuilder()
    {
        $this->builder = ProjectGroup::query();
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (ProjectGroup $projectGroup) {
                return [
                    'id'   => [
                        'display' => $this->repository->getLink($projectGroup, '#' . $projectGroup->id),
                        'raw'     => $projectGroup->id,
                    ],
                    'name' => $projectGroup->name,
                ];
            });
    }
}
