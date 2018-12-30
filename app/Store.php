<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
