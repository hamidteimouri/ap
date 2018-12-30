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
        $this->middlewareCheckPermission();
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

    # create a new user or seller
    public function store()
    {
        try {
            $validate = validator(request()->all(), [
                'name' => 'required|max:190',
                'email' => 'required|unique:users|email|max:190',
                'password' => 'required|min:6|max:190',
                'role' => 'required|in:user,seller',
                'lat' => 'required|max:190',
                'lng' => 'required|max:190',
                'radius' => 'required|max:190',
            ]);
            if ($validate->fails()) {
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
            $object->radius = $input['radius'];
            $object->save();

            return new UserResource($object);


        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }

    }

    # get all seller
    public function seller()
    {
        try {
            $objects = User::isSellerUser()->latest()->paginate($this->paginate);
            return UserResource::collection($objects);
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

    public function createStoreForSeller(User $user)
    {

        try {
            if ($user->isSeller()) {
                $validate = validator(request()->all(), [
                    'title' => 'required|max:190',
                    'lat' => 'required|max:190',
                    'lng' => 'required|max:190',
                    'radius' => 'required|max:190',
                ]);
                if ($validate->fails()) {
                    return response()->json(['error' => $validate->errors()], 422);
                }
                if (!$user->store()->exists()) {
                    $input = request()->all();
                    $store = $user->store()->create([
                        'title' => $input['title'],
                        'lat' => $input['lat'],
                        'lng' => $input['lng'],
                        'radius' => $input['radius'],
                    ]);

                    return response()->json([
                        'store successfully created'
                    ]);
                } else {
                    return response()->json([
                        'this user already has a store'
                    ], 404);
                }
            }
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }
}
