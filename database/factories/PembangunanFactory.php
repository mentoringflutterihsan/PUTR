<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Desa;
use App\Pembangunan;
use Faker\Generator as Faker;

$factory->define(Pembangunan::class, function (Faker $faker) {
    return [
        'name' => substr($faker->jobTitle, 0, 60),
        'address' => $faker->address,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'nilai_kontrak' => $faker->randomNumber(5),
        'panjang_pekerjaan' => $faker->randomNumber(5),
        'desa_id' => factory(Desa::class),
        'volume' => $faker->randomNumber(5),
        'nilai_pagu' => $faker->randomNumber(5),
        'tahun' => $faker->dateTimeBetween('-10 years', 'now')->format('Y')
    ];
});
