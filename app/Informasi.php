<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use rakeshthapac\LaraTime\Traits\LaraTimeable;

class Informasi extends Model
{
    // use LaraTimeable;
    
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function fileInfo()
    {
        return $this->hasMany('App\FileInfo', 'info_id'); //info_id adalah foreign key custom, yang seharusnya informasi_id.
    }

    public function komentarInfo()
    {
        return $this->hasMany('App\KomentarInfo', 'info_id'); //info_id adalah foreign key custom, yang seharusnya informasi_id.
    }
}
