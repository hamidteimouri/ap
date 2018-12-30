<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cart as CartResource;
use Exception;

class CartController extends Controller
{

    public function index()
    {
        try {
            $user = auth()->user();

            if (!$user->cart()->exists()) {
                return response()->json([
                    'msg' => 'Cart is empty'
                ]);
            }
            return new CartResource($user->cart);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function store(Product $product)
    {

        try {
            $user = auth()->user();

            # check for user's cart
            if ($user->cart()->exists()) {
                $cart = $user->cart;

            } else {
                $cart = new Cart();
                $cart->user_id = $user->id;
                $cart->save();
            }
            //$cart->load('items');


            if ($cart->items()->where('product_id', $product->id)->exists()) {
                $cart->items()->where('product_id', $product->id)->increment('quantity');
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                ]);
            }

            return response()->json([
                'msg' => 'product added to your cart'
            ]);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }


    }
}
