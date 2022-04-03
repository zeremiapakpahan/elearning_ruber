<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Guru extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $guard = 'guru';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function kelas()
    {
        return $this->hasMany('App\Kelas');
    }

    public function komentarInfo()
    {
        return $this->hasMany('App\KomentarInfo');
    }

    public function komentarTugas()
    {
        return $this->hasMany('App\KomentarTugas');
    }

    public function komenHasilTugas()
    {
        return $this->hasMany('App\KomenHasilTugas');
    }

    public function anggota()
    {
        return $this->hasOne('App\Anggota');
    }

}
