<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileKomenInfo extends Model
{
    protected $guarded = [];

    
    public function komentarInfo()
    {
        return $this->belongsTo('App\KomentarInfo', 'komen_info_id');
    }
}
