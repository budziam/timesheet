<?php
namespace App\Transformers;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'groups',
    ];

    public function transform(Project $project)
    {
        return [
            'id'          => $project->id,
            'name'        => $project->name,
            'description' => $project->description,
            'endst_at'    => $project->ends_at,
        ];
    }

    public function includeGroups(Project $project)
    {
        return $this->collection($project->groups, new ProjectGroupTransformer);
    }
}