<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $guard = 'admin';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
