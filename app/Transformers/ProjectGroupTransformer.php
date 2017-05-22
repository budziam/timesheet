<?php
namespace App\Transformers;

use App\Models\ProjectGroup;
use League\Fractal\TransformerAbstract;

class ProjectGroupTransformer extends TransformerAbstract
{
    public function transform(ProjectGroup $projectGroup)
    {
        return [
            'id'    => $projectGroup->id,
            'name'  => $projectGroup->name,
        ];
    }
}