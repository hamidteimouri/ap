<?php

namespace App\Http\Controllers\Api;

use App\Factor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Factor as FactorResource;

class UserController extends Controller
{
    public $paginate = 15;


    public function show()
    {
        $user = auth()->user();

        $user->load(['factor']);
    }
}
