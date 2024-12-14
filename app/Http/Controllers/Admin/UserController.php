<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Models\Year;
use App\Traits\Trashable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use Trashable;

    public function datatables(){
        return DataTables::eloquent(User::with('roles')->select('users.*'))
            ->addColumn('role', function (User $user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->addColumn('btn', 'admin.users.partials.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        $user = new User();
        $roles = Role::get();
        $years = Year::all();
        return view('admin.users.create', compact('user', 'roles', 'years'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);

        if ($request->has('role')) {
            $user->assignRole($request->input('role'));
        }

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
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

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        $years = Year::all();
        $currentYear = $user->years()->first();

        return view('admin.users.edit', compact('user', 'roles', 'years', 'currentYear'));
    }

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

                $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            }

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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'El usuario ha sido eliminado con éxito.');
    }

    public function moveToTrash($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('trash.index')->with('success', 'Usuario movido a la papelera.');
    }

    public function restoreFromTrash($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('trash.index')->with('success', 'Usuario restaurado desde la papelera.');
    }

    public function forceDeleteFromTrash($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('trash.index')->with('success', 'Usuario eliminado permanentemente.');
    }
}


