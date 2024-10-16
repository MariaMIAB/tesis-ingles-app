<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function datatables(){
        return DataTables::eloquent(User::with('roles')->select('users.*'))
            ->addColumn('role', function (User $user) {
                return $user->roles->pluck('name')->implode(', ');
            })
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

    public function seeDeleted()
    {
        $trash = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('trash'));
    }

    public function restore($id)
    {
        $usuario = User::withTrashed()->find($id);
        $usuario->restore();
        return redirect()->route('trash.deleted')->with('success', 'Usuario restaurado exitosamente.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles = Role::get();
        $years = Year::all(); // Obtener todos los años
        return view('admin.users.create', compact('user', 'roles', 'years'));
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
    
        if ($user->hasRole('Estudiante')) {
            $yearId = $request->input('current_year') ? Year::where('name', now()->year)->first()->id : $request->input('year');
            $year = Year::with('semesters')->findOrFail($yearId);
    
            $user->years()->attach($year->id);
    
            $semester = $year->semesters->random();
            $user->semesters()->attach($semester->id);
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
        $years = Year::all(); // Obtener todos los años

        // Obtener el año actual del usuario
        $currentYear = $user->years()->first();

        return view('admin.users.edit', compact('user', 'roles', 'years', 'currentYear'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();

        try {
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

            // Asignar año y semestre si el rol es "Estudiante"
            if ($user->hasRole('Estudiante')) {
                $yearId = $request->input('current_year') ? Year::where('name', now()->year)->first()->id : $request->input('year');
                $year = Year::with('semesters')->findOrFail($yearId);

                $user->years()->sync([$year->id]);

                $semester = $year->semesters->random();
                $user->semesters()->sync([$semester->id]);
            }

            return redirect()->route('users.show', [$user->id])->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('users.edit', [$user->id])->with('error', 'Hubo un error al actualizar el usuario.');
        }
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
