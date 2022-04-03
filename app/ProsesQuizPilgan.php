<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsesQuizPilgan extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }

    public function quizPilgan()
    {
        return $this->belongsTo('App\QuizPilgan', 'quiz_pilgan_id');
    }

    public function hasilQuizPilgan()
    {
        return $this->hasOne('App\HasilQuizPilgan');
    }
}
