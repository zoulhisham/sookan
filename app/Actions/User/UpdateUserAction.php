<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction
{
    public function __invoke(Request $request, User $user)
    {
        $password = $user->password;
        if($request->has('password')) {
            $password = Hash::make($request->input('password'));
        }

        $profileImageUrl = $user->profile_image_url;
        if($request->hasFile('profileImage')) {
            $path = $request->file('profileImage')->store("images/$user->id");

            $profileImageUrl = $this->getGeneratedFileName($path);
        }

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $password,
            'phone_no' => $request->input('phone_no'),
            'profile_image_url' => $profileImageUrl
        ]);
    }

    public function getGeneratedFileName(string $path)
    {
        $array = explode('/', $path);

        return end($array);
    }
}