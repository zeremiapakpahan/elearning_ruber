<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function fileTugas()
    {
        return $this->hasMany('App\FileTugas', 'tugas_id');
    }

    public function komentarTugas()
    {
        return $this->hasMany('App\KomentarTugas', 'tugas_id');
    }

    public function prosesTugas()
    {
        return $this->hasMany('App\ProsesTugas', 'tugas_id');
    }


}
