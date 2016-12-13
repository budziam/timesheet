<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\User;
use App\Models\WorkLog;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Project::class, function (Generator $faker) {
    return [
        'name'    => $faker->words(3, true),
        'ends_at' => $faker->dateTimeBetween('-2 months', '+1 year'),
    ];
});

$factory->define(ProjectGroup::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(WorkLog::class, function (Generator $faker) {
    $startsAt = \Carbon\Carbon::instance($faker->dateTimeBetween('-1 week', 'now'));
    $endsAt = $startsAt->copy()->addMinutes($faker->numberBetween(30, 60 * 8));

    return [
        'ends_at'   => $endsAt,
        'starts_at' => $startsAt,
    ];
});