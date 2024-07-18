<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function datatables(){
        return DataTables::eloquent(User::query())
        ->addColumn('btn', 'admin.users.partials.btn')
        ->rawColumns(['btn'])
        ->toJson();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles = Role::get();
        return view('admin.users.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);

        if ($request->has('role')) {
            $user->assignRole($request->input('role'));
        }

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $user
                ->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('users.show', [$user->id])->with('success', 'Usuario guardado correctamente.');
    }




    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();
        
        $user->update($validatedData);
    
        if ($request->has('role')) {
            $newRole = $request->input('role');
            if (!$user->hasRole($newRole)) {
                $user->syncRoles($newRole);
            }
        }
    
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            
            if ($user->getMedia('avatar')->count() > 0) {
                $user->getMedia('avatar')->each(function ($mediaItem) {
                    $mediaItem->delete();
                });
            }
        
            $user
                ->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }
        
    
        return redirect()->route('users.show', [$user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'El Usuario a sido eliminado con exito');
    }
}
