<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [
        'nama_mapel',
	];

    protected $table = 'tbl_mata_pelajarans';
	public $timestamps = false;

    public function JadwalKelas()
    {
        return $this->hasMany('App\Models\Sekolah\JadwalKelas', 'id_matapelajaran');
    }
}
