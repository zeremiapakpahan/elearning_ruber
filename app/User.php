<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }
}
