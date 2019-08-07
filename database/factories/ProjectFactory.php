<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

// use App\Project;
use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(6),
        'notes' => $faker->sentence(4),
        'owner_id' => function() {
            return factory(App\User::class)->create()->id;
        }
    ];
});
