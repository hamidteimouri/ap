<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        #return parent::toArray($request);
        return [
            'title' => $this->title,
            'price' => $this->priceNumberFormat,
        ];
    }

    public function with($request)
    {
        return [
            'store' => $this->store
        ];
    }
}
