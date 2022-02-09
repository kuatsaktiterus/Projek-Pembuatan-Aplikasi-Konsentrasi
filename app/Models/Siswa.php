<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'tbl_siswas';
    public $timestamps = false;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'jenis_kelamin',
        'no_telepon',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'tanggal_diterima',
        'agama',
        'alamat_lengkap',
        'alamat_rt',
        'alamat_rw',
        'alamat_kelurahan',
        'alamat_kecamatan',
        'kode_pos',
        'tinggal_bersama',
        'transportasi',
        'id_user',
        'id_jurusan',
        'foto'
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function Jurusan()
    {
        return $this->belongsTo('App\Models\Jurusan', 'id_jurusan');
    }

    public function PembagianKelasSiswa()
    {
        return $this->hasMany('App\Models\PembagianKelasSiswa', 'id_siswa');
    }
}
