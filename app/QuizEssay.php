<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizEssay extends Model
{
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function prosesQuizEssay()
    {
        return $this->hasMany('App\ProsesQuizEssay');
    }
}
