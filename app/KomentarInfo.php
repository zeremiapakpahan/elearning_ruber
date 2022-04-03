<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarInfo extends Model
{
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo('App\Guru');
    }

    public function siswa()
    {
        return $this->belongsTo('App\Siswa');
    }
    
    public function informasi()
    {
        return $this->belongsTo('App\Informasi', 'info_id'); //info_id adalah foreign key custom, yang seharusnya informasi_id.
    }

    public function fileKomenInfo()
    {
        return $this->hasMany('App\FileKomenInfo', 'komen_info_id');
    }
}
