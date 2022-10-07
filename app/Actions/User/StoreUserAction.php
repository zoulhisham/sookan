<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StoreUserAction
{
    public function __invoke(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_no' => $request->input('phone_no'),
        ]);

        if($request->hasFile('profileImage')) {
            $path = $request->file('profileImage')->store("images/$user->id");

            $user->update([
                'profile_image_url' => $this->getGeneratedFileName($path)
            ]);
        }

        return $user;
    }

    public function getGeneratedFileName(string $path)
    {
        $array = explode('/', $path);

        return end($array);
    }
}