<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarTugas extends Model
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

    public function penugasan()
    {
        return $this->belongsTo('App\Penugasan', 'tugas_id');
    }

    public function fileKomenTugas()
    {
        return $this->hasMany('App\FileKomenTugas', 'komen_tugas_id');
    }
}
