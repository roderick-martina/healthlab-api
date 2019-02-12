<?php

use Faker\Generator as Faker;
use App\Models\Patient;
use App\Models\CustomField;
use Illuminate\Foundation\Auth\User;

$factory->define(CustomField::class, function (Faker $faker) {
    return [
        'field_name' => $faker->name,
    ];
});
