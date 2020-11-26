<?php

use App\Pembangunan;
use Illuminate\Database\Seeder;

class PembangunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Pembangunan::class, 200)->create();
    }
}
