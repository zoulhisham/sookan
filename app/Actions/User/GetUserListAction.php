<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;

class GetUserListAction
{
    public function __invoke(Request $request)
    {
        $users = User::query()
            ->when($request->query('name'), function($query) use($request) {
                $query->where('name', 'like', "%{$request->input('name')}%");
            })
            ->when($request->query('username'), function($query) use($request) {
                $query->where('username', 'like', "%{$request->input('name')}%");
            })
            ->when($request->query('phone_no'), function($query) use($request) {
                $query->where('phone_no', 'like', "%{$request->input('phone_no')}%");
            })
            ->when($request->query('status'), function($query) use($request) {
                $query->where('status', $request->input('status'));
            })
            ->user()
            ->paginate();

        return $users;
    }
}