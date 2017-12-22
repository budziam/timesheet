<?php

use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectGroup;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        switch (app()->environment()) {
            case 'local':
                $this->seedFakeProjectGroups();
                $this->seedFakeCustomers();
                $this->seedFakeProjects();
                break;
        }
    }

    protected function seedFakeProjectGroups()
    {
        factory(ProjectGroup::class, 5)->create();
    }

    protected function seedFakeCustomers()
    {
        factory(Customer::class, 5)->create();
    }

    protected function seedFakeProjects()
    {
        factory(Project::class, 10)->create()
            ->each(function (Project $project) {
                $groups = ProjectGroup::inRandomOrder()
                    ->limit(rand(0, 3))
                    ->get();

                $project->groups()->sync($groups);
            });
    }
}
