<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsesQuizEssay extends Model
{
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }

    public function quizEssay()
    {
        return $this->belongsTo('App\QuizEssay', 'quiz_essay_id');
    }

    public function hasilQuizEssay()
    {
        return $this->hasOne('App\HasilQuizEssay');
    }
}
