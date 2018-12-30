<?php

namespace App\Http\Controllers\Api;

use function GuzzleHttp\Promise\promise_for;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class PassportController extends Controller
{
    public $successStatus = 200;

    public function login()
    {

        try {
            0;
            $validate = validator(request()->all(), [
                'email' => 'required|email|max:190',
                'password' => 'required|min:6|max:190',
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()], 422);
            }
            $input = request()->all();
            if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $user = auth()->user();

                $success['token'] = $user->createToken('MyApp')->accessToken;

                return response()->json(['success' => $success], $this->successStatus);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $exception) {
            dd('Error: ' . $exception->getMessage(), ' | file: ' . $exception->getFile() . ' | line: ' . $exception->getLine());
        }
    }

}
