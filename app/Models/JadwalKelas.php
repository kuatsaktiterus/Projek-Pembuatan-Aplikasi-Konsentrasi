<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pembagian_kelas',
        'id_matapelajaran',
        'id_pengajar',
        'id_jadwal'
    ];
    protected $table = 'tbl_jadwal_kelases';
    public $timestamps = false;

    public function MataPelajaran()
    {
        return $this->belongsTo('App\Models\MataPelajaran', 'id_matapelajaran');
    }

    public function Guru()
    {
        return $this->belongsTo('App\Models\Guru', 'id_pengajar');
    }

    public function Jadwal()
    {
        return $this->belongsTo('App\Models\Jadwal', 'id_jadwal');
    }

    public function PembagianKelas()
    {
        return $this->belongsTo('App\Models\PembagianKelas', 'id_pembagian_kelas');
    }
}
