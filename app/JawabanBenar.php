<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanBenar extends Model
{
    protected $guarded = [];

    public function quizPilgan()
    {
        return $this->belongsTo('App\QuizPilgan', 'quiz_pilgan_id');
    }
}
