<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function kehadiran()
    {
        return $this->hasMany('App\Kehadiran');
    }
}
