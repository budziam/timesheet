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
    return [
        'name'           => $faker->name,
        'fullname'       => $faker->firstName . ' ' . $faker->lastName,
        'remember_token' => str_random(10),
        'password'       => bcrypt(''),
    ];
});

$factory->define(Project::class, function (Generator $faker) {
    return [
        'lkz'         => $faker->asciify(),
        'kerg'        => $faker->asciify('****/**'),
        'name'        => ucfirst($faker->words(3, true)),
        'value'       => $faker->numberBetween(0, 10000),
        'description' => $faker->paragraphs(5, true),
        'ends_at'     => $faker->boolean(80)
            ? Carbon::instance($faker->dateTimeBetween('-2 months', '+1 year'))->startOfDay()
            : null,
        'color'       => $faker->boolean(30) ? $faker->hexColor : null,
    ];
});

$factory->define(ProjectGroup::class, function (Generator $faker) {
    return [
        'name'  => ucfirst($faker->word),
        'color' => $faker->hexColor,
    ];
});

$factory->define(WorkLog::class, function (Generator $faker) {
    return [
        'date'           => Carbon::instance($faker->dateTimeBetween('-1 week', 'now'))->startOfDay(),
        'time_fieldwork' => $faker->numberBetween(30, 8 * 60) * 60,
        'time_office'    => $faker->numberBetween(30, 8 * 60) * 60,
        'comment'        => $faker->boolean(80) ? $faker->sentence : '',
    ];
});