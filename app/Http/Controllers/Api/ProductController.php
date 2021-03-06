<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Product as ProductResource;
use Exception;

class ProductController extends Controller
{
    public $paginate = 15;

    public function index()
    {
        try {
            $user = auth()->user();
            $lat = $user->lat;
            $lon = $user->lng;
            $radius = $user->radius;
            $objects = Product::latest()->paginate($this->paginate);
            return $objects = ProductResource::collection($objects);

            /*
            $res = Product::select(
                \DB::raw("*,
                              ( 6371 * acos( cos( radians(?) ) *
                                 cos( radians( lat ) )
                                 * cos( radians( lon ) - radians(?)
                                 ) + sin( radians(?) ) *
                                 sin( radians( lat ) ) )
                               ) AS distance"))
                ->having("distance", "<", "?")
                ->orderBy("distance")
                ->setBindings([$lat, $lon, $lat, $radius])
                ->get();

            */


        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }

    }

    public function store()
    {
        try {
            $validate = validator(request()->all(), [
                'title' => 'required|max:190',
                'price' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()], 422);
            }
            $input = request()->all();

            # create new product
            $object = new Product;
            $object->store_id = auth()->user()->store->id;
            $object->title = $input['title'];
            $object->price = $input['price'];  # sanitized by model
            $object->save();

            return new ProductResource($object);

        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }

    }
}
