<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembagianKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembagian_kelases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelas');
            $table->string('nama_kelas');
            $table->unsignedBigInteger('wali_kelas',);

            $table->index('wali_kelas');
            $table->index('id_kelas');
            $table->foreign('wali_kelas')->references('id')->on('gurus');
            $table->foreign('id_kelas')->references('id')->on('tbl_kelases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembagian_kelas');
    }
}
