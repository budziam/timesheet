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
            ->limit(rand(0, 6))
            ->get()
            ->each(function (Project $project) use ($user) {
                $date = Carbon::now()->subMonths(2);

                while ($date->lt(Carbon::now())) {
                    factory(WorkLog::class)
                        ->create([
                            'date'       => $date->copy()->startOfDay(),
                            'project_id' => $project->getKey(),
                            'user_id'    => $user->getKey(),
                        ]);

                    do {
                        $date->addDays(rand(1, 3));
                    } while ($date->isWeekend());
                }
            });
    }
}
