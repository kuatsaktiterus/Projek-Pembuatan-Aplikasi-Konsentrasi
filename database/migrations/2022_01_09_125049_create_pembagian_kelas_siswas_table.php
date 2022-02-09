<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembagianKelasSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembagian_kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_pembagian_kelas');

            // relation
            $table->index('id_siswa');
            $table->index('id_pembagian_kelas');
            $table->foreign('id_siswa')->references('id')->on('tbl_siswas');
            $table->foreign('id_pembagian_kelas')->references('id')->on('tbl_pembagian_kelases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembagian_kelas_siswas');
    }
}
