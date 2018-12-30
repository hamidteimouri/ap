<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';                       # it is not necessary


    # mutator
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = removeSpecialChar($value);
    }

    # accessor
    public function getPriceNumberFormatAttribute()
    {
        $price = 0;
        if ($this->price) $price = $this->price;
        return number_format($price);
    }

    # relations
    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault();
    }
}
