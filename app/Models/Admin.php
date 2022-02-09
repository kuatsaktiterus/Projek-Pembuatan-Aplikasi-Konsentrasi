<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama', 'id_user'];

    protected $table = 'tbl_admins';
    public $timestamps = false;


    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
