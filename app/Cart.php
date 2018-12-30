<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($cart) { // before delete() method call this
            $cart->items()->delete();
        });
    }
}
