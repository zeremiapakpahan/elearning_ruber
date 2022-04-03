<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhQe extends Model
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
