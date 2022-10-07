<?php

namespace App\Http\Controllers;

use App\Actions\User\GetUserDetailAction;
use App\Actions\User\GetUserListAction;
use App\Actions\User\StoreUserAction;
use App\Actions\User\UpdateUserAction;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request, GetUserListAction $getUserListAction)
    {
        abort_if(
            !Auth::user()->can('users-view'),
            Response::HTTP_FORBIDDEN,
            __('message.unauthorized')
        );

        $users = $getUserListAction($request);

        return $this->responseData(UserResource::collection($users));
    }

    public function store(StoreUserRequest $request, StoreUserAction $storeUserAction)
    {
        $user = $storeUserAction($request);

        $role = Role::findByName('user');
        $user->assignRole($role);

        return $this->responseCreated();
    }

    public function show(User $user)
    {
        abort_if(
            !Auth::user()->can('users-view'),
            Response::HTTP_FORBIDDEN,
            __('message.unauthorized')
        );
        
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, UpdateUserAction $updateUserAction, User $user)
    {
        $updateUserAction($request, $user);

        return $this->responseUpdated();
    }

    public function destroy(User $user)
    {
        abort_if(
            !Auth::user()->can('users-delete'),
            Response::HTTP_FORBIDDEN,
            __('message.unauthorized')
        );

        $user->delete();

        return $this->responseDeleted();
    }
}
