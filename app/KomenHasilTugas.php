<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomenHasilTugas extends Model
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

    public function hasilTugas()
    {
        return $this->belongsTo('App\HasilTugas', 'hasil_tugas_id');
    }

    public function fileKomenHasilTugas()
    {
        return $this->hasMany('App\FileKomenHasilTugas');
    }
}
