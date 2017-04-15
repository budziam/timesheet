<?php
namespace App\Transformers\Dashboard;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        return [
            'id'          => $project->id,
            'name'        => $project->name,
            'color'       => $project->color,
            'description' => $project->description,
            'ends_at'     => str_replace(' ', 'T', $project->ends_at),
            'created_at'  => $project->created_at->toDateTimeString(),
            'updated_at'  => $project->updated_at->toDateTimeString(),
        ];
    }
}