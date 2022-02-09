<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('no_telepon');
            $table->string('nisn')->unique();
            $table->string('nik')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['islam','kristen protestan', 'kristen katolik', 'hindu', 'buddha', 'konghucu']);
            $table->string('alamat_lengkap');
            $table->string('alamat_rt');
            $table->string('alamat_rw');
            $table->string('alamat_kelurahan');
            $table->string('alamat_kecamatan');
            $table->char('kode_pos',8);
            $table->enum('tinggal_bersama',['orang tua','wali','sendiri']);
            $table->enum('transportasi',['angkutan umum','kendaraan pribadi','antar jemput', 'jalan kaki']);
            $table->string('foto')->default('Default.png');

            $table->unsignedBigInteger('id_user',);    
            $table->index('id_user');
            $table->foreign('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('siswas');
    }
}
