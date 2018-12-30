<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSeller()
    {
        return $this->role == 'seller';
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    # mutator(s)
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    # scopes
    public function scopeIsNotAdmin($qeury)
    {
        return $qeury->where('role', '!=', 'admin');
    }

    # relations
    public function factors()
    {
        return $this->hasMany(Factor::class);
    }
}
