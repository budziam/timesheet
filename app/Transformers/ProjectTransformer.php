<?php
namespace App\Transformers;

use App\Models\Project;
use App\Transformers\Dashboard\CustomerTransformer;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'groups',
    ];

    protected $availableIncludes = [
        'customer',
    ];

    public function transform(Project $project)
    {
        return [
            'id'          => $project->id,
            'lkz'         => $project->lkz,
            'kerg'        => $project->kerg,
            'name'        => $project->name,
            'description' => $project->description,
            'ends_at'     => $project->ends_at ? $project->ends_at->toDateString() : null,
            'color'       => $project->real_color,
        ];
    }

    public function includeCustomer(Project $project)
    {
        if (!$project->customer) {
            return $this->null();
        }

        return $this->item($project->customer, new CustomerTransformer);
    }

    public function includeGroups(Project $project)
    {
        return $this->collection($project->groups, new ProjectGroupTransformer);
    }
}
