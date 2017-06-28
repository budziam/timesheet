<?php
namespace App\Transformers;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectSelect2Transformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        return [
            'id'   => $project->id,
            'text' => $project->lkz . ', ' . $project->kerg . ' ' . $project->name,
        ];
    }
}