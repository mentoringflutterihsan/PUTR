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
            $table->string('longitude', 15)->nullable();
            $table->integer('nilai_kontrak')->default(0);
            $table->integer('panjang_pekerjaan')->default(0);
            $table->integer('desa_id')->default(0);
            $table->string('volume');
            $table->string('nilai_pagu');
            $table->mediumInteger('tahun')->default(0);
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
        Schema::dropIfExists('pembangunan');
    }
}
