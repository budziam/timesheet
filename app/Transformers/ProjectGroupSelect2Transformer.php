<?php
namespace App\Transformers;

use App\Models\ProjectGroup;
use League\Fractal\TransformerAbstract;

class ProjectGroupSelect2Transformer extends TransformerAbstract
{
    public function transform(ProjectGroup $projectGroup)
    {
        return [
            'id'   => $projectGroup->id,
            'text' => $projectGroup->name,
        ];
    }
}