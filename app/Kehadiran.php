<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }

    public function pertemuan()
    {
        return $this->belongsTo('App\Pertemuan');
    }
}
