<?php
namespace App\Transformers\Dashboard;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'customer',
        'groups',
    ];

    public function transform(Project $project)
    {
        return [
            'id'          => $project->id,
            'lkz'         => $project->lkz,
            'kerg'        => $project->kerg,
            'name'        => $project->name,
            'value'       => $project->value,
            'cost'        => $project->cost,
            'color'       => $project->color,
            'description' => $project->description,
            'ends_at'     => $project->ends_at ? $project->ends_at->toDateString() : null,
            'created_at'  => $project->created_at->toDateTimeString(),
            'updated_at'  => $project->updated_at->toDateTimeString(),
        ];
    }

    public function includeGroups(Project $project)
    {
        return $this->collection($project->groups, new ProjectGroupTransformer());
    }

    public function includeCustomer(Project $project)
    {
        if ($project->customer === null) {
            return $this->null();
        }

        return $this->item($project->customer, new CustomerTransformer());
    }
}
