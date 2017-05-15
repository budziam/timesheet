<?php
namespace App\Repositories;

use App\Models\ProjectGroup;

class ProjectGroupRepository
{
    public function getLink(ProjectGroup $projectGroup, $title = null) : string
    {
        $title = $title ?? $projectGroup->name;

        return (string)link_to_route('dashboard.project-groups.edit', $title, $projectGroup->getRouteKey());
    }
}