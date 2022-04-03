<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileKomenTugas extends Model
{
    protected $guarded = [];

    public function komentarTugas()
    {
        return $this->belongsTo('App\KomentarTugas', 'komen_tugas_id');
    }
}
