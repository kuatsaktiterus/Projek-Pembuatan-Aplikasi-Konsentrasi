<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_kelases', function (Blueprint $table) {
            $table->id();
            $table->enum('kelas',['X','XI', 'XII']);
            $table->unsignedBigInteger('id_jurusan',);
            $table->index('id_jurusan');
            $table->foreign('id_jurusan')->references('id')->on('tbl_jurusans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}
