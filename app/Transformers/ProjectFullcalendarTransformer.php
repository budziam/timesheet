<?php
namespace App\Transformers;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectFullcalendarTransformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        return [
            'id'   => $project->id,
            'lkz'  => $project->lkz,
            'kerg' => $project->kerg,
            'name' => $project->name,
        ];
    }
}