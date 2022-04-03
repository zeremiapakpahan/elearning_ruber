<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilQuizEssay extends Model
{
    protected $guarded = [];

    public function prosesQuizEssay()
    {
        return $this->belongsTo('App\ProsesQuizEssay', 'proses_quiz_essay_id');
    }
}
