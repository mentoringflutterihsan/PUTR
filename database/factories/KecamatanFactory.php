<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kecamatan;
use Faker\Generator as Faker;

$factory->define(Kecamatan::class, function (Faker $faker) {
    return [
        'nama_kecamatan' => $faker->word(1),
        'luas_wilayah' => $faker->randomNumber(5)
    ];
});
