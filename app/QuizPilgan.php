<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizPilgan extends Model
{
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function jawabanBenar()
    {
        return $this->hasOne('App\JawabanBenar');
    }

    public function prosesQuizPilgan()
    {
        return $this->hasMany('App\ProsesQuizPilgan');
    }
    

}
