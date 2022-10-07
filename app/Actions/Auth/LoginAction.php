<?php

namespace App\Actions\Auth;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginAction
{

    public function __invoke(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        abort_if(
            !$user,
            Response::HTTP_FORBIDDEN,
            __('auth.failed')
        );

        abort_if(
            !Hash::check($request->input('password'), $user->password),
            Response::HTTP_FORBIDDEN,
            __('auth.password')
        );

        abort_if(
            $user->status != UserStatus::Active->value,
            Response::HTTP_FORBIDDEN,
            __('auth.status')
        );

        return $user;
    }
}