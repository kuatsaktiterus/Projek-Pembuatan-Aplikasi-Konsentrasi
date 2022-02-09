<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanGuru extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengumuman',
        'waktu_pengumuman',
        'id_guru',
    ];
    protected $table = 'tbl_pengumuman_gurus';
    public $timestamps = false;

    public function Guru()
    {
        return $this->belongsTo('App\Models\Guru', 'id_guru');
    }
}
