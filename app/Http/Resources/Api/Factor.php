<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class Factor extends JsonResource
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
            'id' => $this->id,
            'price' => $this->price,
            'code' => $this->code,
            'status' => $this->status,
        ];
    }

    public function with($request)
    {
        return [
            'orders' => $this->orders,
        ];
    }
}
