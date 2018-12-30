<?php

namespace App\Http\Controllers\Api;

use App\Factor;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Factor as FactorResource;

class FactorController extends Controller
{
    public $paginate = 15;

    public function index()
    {
        $user = auth()->user();
        $objects = Factor::where('user_id', $user->id)->paginate($this->paginate);
        return FactorResource::collection($objects);
    }

    public function show(Factor $factor)
    {
        if ($factor->user_id != auth()->id()) {
            return response()->json([
                'error' => 'Access Denied'
            ], 403);
        }
        return new FactorResource($factor);
    }

    public function store()
    {
        $user = auth()->user();

        if (!$user->cart()->exists()) {
            return response()->json([
                'status' => 'Your cart is empty'
            ], 404);
        }
        $user->load(['cart.items', 'cart.items.product']);

        $factor = new Factor;
        $factor->user_id = $user->id;
        $factor->save();

        $sum = 0;
        foreach ($user->cart->items as $item) {
            $i = new Order();
            $i->product_id = $item->product_id;
            $i->factor_id = $factor->id;
            $i->fee = $item->product->price;
            $i->quantity = $item->quantity;
            $i->save();

            $sum += ($i->fee * $i->quantity);
        }
        $factor->price = $sum;
        $factor->save();

        # empty cart and items
        $user->cart->delete();

        return response()->json([
            'msg' => 'you should pay you factor...'
        ]);


    }
}
