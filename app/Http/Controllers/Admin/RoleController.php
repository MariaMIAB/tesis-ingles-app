<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\UpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function datatables(){
        return DataTables::eloquent(Role::query())
        ->addColumn('btn', 'admin.roles.partials.btn')
        ->rawColumns(['btn'])
        ->toJson();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = $role->permissions;
        return view('admin.roles.show', compact('role', 'permissions')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $allPermissions = Permission::all();
        $rolePermissions = $role->permissions;
        return view('admin.roles.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $validatedData = $request->validated();
        $permissions = $validatedData['permissions'];
        $role->permissions()->sync($permissions);
    
        return redirect()->route('roles.show', [$role->id])->with('success', 'Permisos actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
