<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Http\Resources\Api\Admin\User as UserResource;

class UserController extends Controller
{
    protected $paginate = 15;

    public function __construct()
    {
//        $this->middlewareCheckPermission();/
    }

    # this is for check user is a seller or not
    public function middlewareCheckPermission()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                return response()->json(['error' => "You don't have permission"], 403);
            }
            return $next($request);
        });
    }

    # get all user , seller
    public function index()
    {
        try {
            $objects = User::isNotAdmin()->latest()->paginate($this->paginate);
            return UserResource::collection($objects);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function store()
    {
        try {
            $validate = validator(request()->all(), [
                'name' => 'required|max:190',
                'email' => 'required|unique:users|email|max:190',
                'password' => 'required|min:6|max:190',
                'lat' => 'required|max:190',
                'lng' => 'required|max:190',
            ]);
            if ($validate->fails()) {
                // return response()->json(['error' => "Unprocessable Entity"], 422);
                return response()->json(['error' => $validate->errors()], 422);
            }
            $input = request()->all();

            # create new User
            $object = new User;
            $object->name = $input['name'];
            $object->email = $input['email'];
            $object->role = $input['role'];
            $object->password = $input['password'];   # Hashed by model
            $object->lat = $input['lat'];
            $object->lng = $input['lng'];
            $object->save();

            return new UserResource($object);


        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }

    }
}
