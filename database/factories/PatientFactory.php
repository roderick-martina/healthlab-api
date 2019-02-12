<?php

use Faker\Generator as Faker;
use App\Models\Patient;
use App\User;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'identifier' => (string) $faker->randomNumber(),
        'valid_identifier' => true,
        'gender' => 'Male',
        'age' => 1,
    ];
});
