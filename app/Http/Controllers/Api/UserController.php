<?php

namespace App\Http\Controllers\Api;

use App\Factor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Factor as FactorResource;

class UserController extends Controller
{
    public $paginate = 15;

    public function factors()
    {
        $user = auth()->user();
        $objects = Factor::where('user_id', $user->id)->paginate($this->paginate);
        return FactorResource::collection($objects);
    }

    public function showFactor(Factor $factor)
    {
        if ($factor->user_id != auth()->id()) {
            return response()->json([
                'error' => 'Access Denied'
            ], 403);
        }
        return new FactorResource($factor);
    }
}
