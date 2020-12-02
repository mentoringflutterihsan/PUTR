<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Desa;
use App\Kecamatan;
use Faker\Generator as Faker;

$factory->define(Desa::class, function (Faker $faker) {
    return [
        'kecamatan_id' => factory(Kecamatan::class),
        'nama_desa' => $faker->word(1),
        'luas_wilayah' => $faker->randomNumber(5)
    ];
});
