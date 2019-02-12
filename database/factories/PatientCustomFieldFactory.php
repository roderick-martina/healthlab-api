<?php

use Faker\Generator as Faker;
use App\Models\PatientCustomField;
use App\Models\CustomField;

$factory->define(PatientCustomField::class, function (Faker $faker) {
    return [
        'patient_id' => factory(Patient::class)->create()->id,
        'custom_field_id' => factory(CustomField::class)->create()->id,
        'value' => 'test'
    ];
});
