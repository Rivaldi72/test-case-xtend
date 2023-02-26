<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Resources\UserResources;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('show-all-users');
        $users = User::all();

        return UserResources::collection($users);
    }

    public function store(RegisterRequest $request)
    {
        $this->authorize('create-delete-users');
        $request->validated();
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Add User Success',
            'data' => $user,
        ]);
    }

    public function show(User $user)
    {
        return new UserResources($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return new UserResources($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete User Success',
        ]);
    }
}
