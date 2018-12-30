<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    public function factor()
    {
        return $this->belongsTo(Factor::class)->withDefault();
    }
}
