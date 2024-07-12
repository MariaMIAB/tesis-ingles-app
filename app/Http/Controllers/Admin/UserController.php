<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:Administrador,Profesor,Estudiante'
        ]);
        $user = User::create($request->all());
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        $user->assignRole($request->input('role'));

        return redirect()->route('users.show',[$user->id]);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $avatarUrl = $user->getFirstMediaUrl('avatar');
        $ava = str_replace(['http://', 'https://', 'localhost/'], '', $avatarUrl);
        return view('admin.users.show', compact('user','ava'));
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        $user->assignRole($request->input('role'));

        $user->save();

        return view('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('eliminar', 'ok');
    }
}
