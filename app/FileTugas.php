<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileTugas extends Model
{
    protected $guarded = [];

    
    public function penugasan()
    {
        return $this->belongsTo('App\Penugasan', 'tugas_id');
    }
}
