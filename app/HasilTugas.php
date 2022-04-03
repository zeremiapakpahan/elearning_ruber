<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilTugas extends Model
{
    protected $guarded = [];

    public function prosesTugas()
    {
        return $this->belongsTo('App\ProsesTugas');
    }

    public function komenHasilTugas()
    {
        return $this->hasMany('App\KomenHasilTugas');
    }
}
