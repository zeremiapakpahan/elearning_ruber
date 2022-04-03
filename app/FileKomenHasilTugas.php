<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileKomenHasilTugas extends Model
{
    protected $guarded = [];

    public function komenHasilTugas()
    {
        return $this->belongsTo('App\KomenHasilTugas', 'komen_hasil_tugas_id');
    }
}
