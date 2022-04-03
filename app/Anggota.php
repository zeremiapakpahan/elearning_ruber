<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

}
