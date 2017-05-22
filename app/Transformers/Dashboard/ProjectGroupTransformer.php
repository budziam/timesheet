<?php
namespace App\Transformers\Dashboard;

use App\Models\ProjectGroup;
use League\Fractal\TransformerAbstract;

class ProjectGroupTransformer extends TransformerAbstract
{
    public function transform(ProjectGroup $projectGroup)
    {
        return [
            'id'    => $projectGroup->id,
            'name'  => $projectGroup->name,
            'color' => $projectGroup->color,
        ];
    }
}