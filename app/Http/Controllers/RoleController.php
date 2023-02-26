<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\RoleResources;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('manage-roles');
        $roles = Role::all();

        return RoleResources::collection($roles);
    }

    public function store(Request $request)
    {
        $this->authorize('manage-roles');
        $role = new Role([
            'name' => $request->name,
        ]);

        $role->save();

        return response()->json([
            'success' => true,
            'message' => 'Add Role Success',
            'data' => $role,
        ]);
    }

    public function show(Role $role)
    {
        $this->authorize('manage-roles');
        return new RoleResources($role);
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('manage-roles');
        $role->update($request->all());

        return new RoleResources($role);
    }

    public function destroy(Role $role)
    {
        $this->authorize('manage-roles');
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Role Success',
        ]);
    }
}
