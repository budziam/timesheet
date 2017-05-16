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
        return User::forceCreate([
            'name'     => 'admin',
            'password' => bcrypt('mbmbmb'),
            'is_admin' => true,
        ]);
    }

    protected function seedFakeUsers()
    {
        factory(User::class, 3)->create()
            ->each(function (User $user) {
                $this->seedFakeWorkLogs($user);
            });
    }

    protected function seedFakeWorkLogs(User $user)
    {
        Project::inRandomOrder()
            ->limit(rand(2, 6))
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
