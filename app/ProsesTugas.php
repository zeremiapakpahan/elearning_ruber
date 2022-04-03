<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsesTugas extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }

    public function penugasan()
    {
        return $this->belongsTo('App\Penugasan', 'tugas_id');
    }

    public function hasilTugas()
    {
        return $this->hasOne('App\HasilTugas');
    }
    
    public function fileProsesTugas() {
        return $this->hasMany('App\FileProsesTugas');
    }
}
