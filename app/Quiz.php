<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function quizPilgan() 
    {
        return $this->hasMany('App\QuizPilgan');
    }

    public function quizEssay() 
    {
        return $this->hasMany('App\QuizEssay');
    }

    public function whQp()
    {
        return $this->hasMany('App\WhQp');
    }

    public function whQe()
    {
        return $this->hasMany('App\WhQe');
    }
}
