<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middlewareCheckPermission();
    }

    # this is for check user is a seller or not
    public function middlewareCheckPermission()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSeller()) {
                return response()->json(['error' => "You don't have permission"], 403);
            }
            return $next($request);
        });
    }

}
