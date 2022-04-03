<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhQp extends Model
{
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }
}
