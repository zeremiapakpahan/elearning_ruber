<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileInfo extends Model
{
    protected $guarded = [];

    public function informasi()
    {
        return $this->belongsTo('App\Informasi', 'info_id'); //info_id adalah foreign key custom, yang seharusnya informasi_id.
    }
}
