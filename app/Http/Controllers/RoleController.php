<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
        DB::beginTransaction();
        try {            
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
    
        return view('roles.show', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'required',
        ]);
    
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permissions'));
    
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        
        // Can't delete admin role
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')
                ->with('error', 'You cannot delete the Admin role');
        }
        
        $role->delete();
        
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
