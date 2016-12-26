<?php

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        switch (app()->environment()) {
            case 'local':
                $this->seedAdminUser();
                $this->seedFakeUsers();
                break;

            default:
                $this->seedAdminUser();
                break;
        }
    }

    protected function seedAdminUser()
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'example@example.com',
            'password' => bcrypt('abc123'),
        ]);
    }

    protected function seedFakeUsers()
    {
        factory(User::class, 10)->create()
            ->each(function (User $user) {
                $this->seedFakeWorkLogs($user);
            });
    }

    protected function seedFakeWorkLogs(User $user)
    {
        Project::inRandomOrder()
            ->limit(rand(0, 5))
            ->get()
            ->each(function (Project $project) use ($user) {
                factory(WorkLog::class, rand(1, 20))
                    ->create([
                        'project_id' => $project->getKey(),
                        'user_id'    => $user->getKey(),
                    ]);
            });
    }
}
