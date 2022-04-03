<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Siswa extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $guard = 'siswa';
    protected $guarded = [];

    public function user() 
    {
        return $this->hasOne('App\User');
    }

    public function anggota()
    {
        return $this->hasMany('App\Anggota');
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

    public function prosesTugas()
    {
        return $this->hasMany('App\ProsesTugas');
    }

    public function prosesQuizPilgan()
    {
        return $this->hasMany('App\ProsesQuizPilgan');
    }

    public function prosesQuizEssay()
    {
        return $this->hasMany('App\ProsesQuizEssay');
    }

    public function kehadiran()
    {
        return $this->hasMany('App\Kehadiran');
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
