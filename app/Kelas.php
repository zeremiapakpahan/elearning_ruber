<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }

    public function informasi()
    {
        return $this->hasMany('App\Informasi');
    }

    public function penugasan()
    {
        return $this->hasMany('App\Penugasan');
    }

    public function quiz()
    {
        return $this->hasMany('App\Quiz');
    }

    public function pertemuan()
    {
        return $this->hasMany('App\Pertemuan');
    }

    public function anggota()
    {
        return $this->hasMany('App\Anggota');
    }
}
