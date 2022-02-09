<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pengumuman_gurus', function (Blueprint $table) {
            $table->id();
            $table->string('pengumuman');
            $table->date('waktu_pengumuman');
            
            $table->unsignedBigInteger('id_guru');            
            $table->index('id_guru');
            $table->foreign('id_guru')->references('id')->on('gurus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengumuman_gurus');
    }
}
