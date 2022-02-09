<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jadwal_kelases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembagian_kelas',);
            $table->unsignedBigInteger('id_matapelajaran',);
            $table->unsignedBigInteger('id_pengajar',);
            $table->unsignedBigInteger('id_jadwal',);


            // relation
            $table->index('id_pembagian_kelas');
            $table->index('id_matapelajaran');
            $table->index('id_pengajar');
            $table->index('id_jadwal');

            $table->foreign('id_pembagian_kelas')->references('id')->on('tbl_pembagian_kelases');
            $table->foreign('id_matapelajaran')->references('id')->on('tbl_mata_pelajarans');
            $table->foreign('id_pengajar')->references('id')->on('gurus');
            $table->foreign('id_jadwal')->references('id')->on('tbl_jadwals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_kelas');
    }
}
