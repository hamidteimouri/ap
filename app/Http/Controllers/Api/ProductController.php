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
            $objects = Product::latest()->paginate($this->paginate);
            return $objects = ProductResource::collection($objects);

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
                // return response()->json(['error' => "Unprocessable Entity"], 422);
                return response()->json(['error' => $validate->errors()], 422);
            }
            $input = request()->all();

            # create new product
            $object = new Product;
            $object->title = $input['title'];
            $object->price = $input['price'];  # sanitized by model
            $object->save();

            $objects = Product::latest()->paginate($this->paginate);
            return $objects = ProductResource::collection($objects);

        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }

    }
}
