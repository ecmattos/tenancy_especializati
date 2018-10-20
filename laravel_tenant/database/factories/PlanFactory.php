<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Entities\Plan::class, function (Faker $faker) {
    return [
        'code' => $faker->numberBetween(100000,999999),
        'description' => $faker->name,
        'details' => $faker->text,
        'plan_type_id' => $faker->numberBetween(1,3),
        'plan_sub_type_id' => $faker->numberBetween(1,7),
        'plan_status_id' => $faker->numberBetween(1,2),
        'price' => $faker->numberBetween(100,999)
    ];
});