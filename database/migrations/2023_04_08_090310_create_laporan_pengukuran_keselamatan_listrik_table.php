<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_pengukuran_keselamatan_listrik', function (Blueprint $table) {
            $table->id();
            $table->string('no_laporan', 100);
            $table->foreign('no_laporan')->references('no_laporan')->on('laporans')->cascadeOnDelete();
            $table->string('field_keselamatan_listrik')->nullable();
            $table->string('slug')->nullable();
            $table->string('value')->nullable();
            $table->string('tahun', 4);
            // LIVE TO NETRAL
            $table->double('intercept1', 15, 9)->nullable();
            $table->double('x_variable1', 15, 9)->nullable();
            // EARTH TO NETRAL
            $table->double('intercept2', 15, 9)->nullable();
            $table->double('x_variable2', 15, 9)->nullable();
            // LIVE TO EARTH
            $table->double('intercept3', 15, 9)->nullable();
            $table->double('x_variable3', 15, 9)->nullable();

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
        Schema::dropIfExists('laporan_pengukuran_keselamatan_listrik');
    }
};
