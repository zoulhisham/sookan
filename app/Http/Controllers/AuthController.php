<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $loginAction)
    {
        $user = $loginAction($request);

        return $this->responseData([
            'user' => new UserResource($user),
            'type' => 'Bearer',
            'token' => $user->createToken('*')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->responseGranted();
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return $this->responseData(new UserResource($user));
    }
}
