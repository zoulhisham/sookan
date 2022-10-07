<?php

namespace App\Http\Requests;

use App\Actions\User\GetUserDetailAction;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('users-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'name' => 'required|max:255',
            'username' => [
                'required', 'max:255',
                Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')
            ],
            'email' => [
                'required', 'email', 'max:255', 
                Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')
            ],
            'phone_no' => 'required|max:15',
            'password' => [
                'string', 'confirmed',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->mixedCase(),
            ]
        ];
    }
}
