<?php

use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        switch (app()->environment()) {
            case 'local':
                $this->seedFakeWorkLogs($this->seedAdminUser());
                $this->seedFakeUsers();
                break;

            default:
                $this->seedAdminUser();
                break;
        }
    }

    protected function seedAdminUser()
    {
        return User::create([
            'name'     => 'admin',
            'password' => bcrypt(''),
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
                $date = Carbon::now()->subMonths(3);

                while ($date->lt(Carbon::now())) {
                    $type = rand(1, 2);

                    factory(WorkLog::class)
                        ->create([
                            'date'       => $date->copy()->startOfDay(),
                            'type'       => $type,
                            'project_id' => $project->getKey(),
                            'user_id'    => $user->getKey(),
                        ]);

                    if (rand() % 2) {
                        factory(WorkLog::class)
                            ->create([
                                'date'       => $date->copy()->startOfDay(),
                                'type'       => $type % 2 + 1,
                                'project_id' => $project->getKey(),
                                'user_id'    => $user->getKey(),
                            ]);
                    }

                    $date->addDays(rand(1, 4));
                }
            });
    }
}
