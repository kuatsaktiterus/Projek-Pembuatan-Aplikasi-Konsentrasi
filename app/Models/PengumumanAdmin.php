<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanAdmin extends Model
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
    ];
    protected $table = 'tbl_pengumuman_admins';
    public $timestamps = false;
}
