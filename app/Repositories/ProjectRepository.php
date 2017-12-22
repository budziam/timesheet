<?php
namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function getLink(Project $project, string $title = null) : string
    {
        $title = $title ?? $project->lkz;

        return link_to_route('dashboard.projects.edit', $title, $project->getRouteKey());
    }
}