<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilQuizPilgan extends Model
{
    protected $guarded = [];

    public function prosesQuizPilgan()
    {
        return $this->belongsTo('App\ProsesQuizPilgan', 'proses_quiz_pilgan_id');
    }
}
