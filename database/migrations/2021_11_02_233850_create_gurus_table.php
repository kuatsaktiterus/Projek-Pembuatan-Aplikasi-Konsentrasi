<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            
            $table->id();
            $table->string('nip')->unique();
            $table->string('golongan');
            $table->string('nama');
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('alamat');
            $table->string('no_telepon');
            $table->string('pendidikan_terakhir');
            $table->string('jurusan_pendidikan');
            $table->string('foto')->default('Default.png');
    
            $table->unsignedBigInteger('id_user',);    
            $table->index('id_user');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gurus');
    }
}
