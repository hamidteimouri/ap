<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'title', 'lat', 'lng','radius'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
