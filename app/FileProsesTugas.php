<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileProsesTugas extends Model
{
    protected $guarded = [];

    public function prosesTugas() {
        return $this->belongsTo('App\ProsesTugas');
    }
}
