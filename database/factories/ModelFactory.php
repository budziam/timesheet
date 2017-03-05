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
use Carbon\Carbon;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name'           => $faker->firstName . ' ' . $faker->lastName,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Project::class, function (Generator $faker) {
    return [
        'name'        => ucfirst($faker->words(3, true)),
        'description' => $faker->paragraphs(5, true),
        'ends_at'     => $faker->dateTimeBetween('-2 months', '+1 year'),
        'color'       => $faker->boolean(80) ? $faker->hexColor : null,
    ];
});

$factory->define(ProjectGroup::class, function (Generator $faker) {
    return [
        'name' => ucfirst($faker->word),
    ];
});

$factory->define(WorkLog::class, function (Generator $faker) {
    return [
        'date'           => Carbon::instance($faker->dateTimeBetween('-1 week', 'now'))->startOfDay(),
        'time_fieldwork' => $faker->boolean(80) ? $faker->numberBetween(30 * 60, 8 * 60 * 60) : 0,
        'time_office'    => $faker->boolean(80) ? $faker->numberBetween(30 * 60, 8 * 60 * 60) : 0,
    ];
});