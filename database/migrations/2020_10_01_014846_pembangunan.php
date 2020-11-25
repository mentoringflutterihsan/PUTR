<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pembangunan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembangunan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('address')->nullable();
            $table->string('latitude', 15)->nullable();
            $table->string('longtitude', 15)->nullable();
            $table->integer('nilai_kontrak')->nullable();
            $table->integer('panjang_pekerjaan')->nullable();
         
            $table->foreignId('desa_id')->references('id')->on('desas');
            $table->string('volume');
            $table->string('nilai_pagu');
            $table->date('tahun');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pembangunan');
    }
}
