<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(6),
        'project_id' => function () {
            return factory(App\Project::class)->create()->id;
        }
    ];
});
