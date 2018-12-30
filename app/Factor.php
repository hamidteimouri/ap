<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->code = $this->setCode();
    }

    # factor code for users
    public function setCode()
    {
        $code = rand(100000, 900000);
        while (Factor::where('code', $code)->exists()) {
            $code = rand(100000, 900000);
        }
        return $code;
    }

    # relations
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
