<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Topic;

class ActivityController extends Controller
{

    public function datatables()
    {
        $query = Activity::with('topic');
    
        return DataTables::eloquent($query)
            ->addColumn('topic_name', function (Activity $activity) {
                return $activity->topic->name;
            })
            ->addColumn('btn', 'admin.activities.partials.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }
    

    // Listar todas las actividades
    public function index()
    {
        $activities = Activity::with('topic')->get();
        return view('admin.activities.index', compact('activities'));
    }

    // Mostrar el formulario para crear una nueva actividad
    public function create()
    {
        $topics = Topic::all();
        return view('admin.activities.create', compact('topics'));
    }

    // Almacenar una nueva actividad
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'required|url',
            'status' => 'boolean',
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Crear la actividad
        Activity::create($request->all());

        return redirect()->route('activities.index')->with('success', 'Actividad creada exitosamente');
    }

    // Mostrar una actividad específica
    public function show($id)
    {
        $activity = Activity::with('topic')->findOrFail($id);
        $embedLink = str_replace("/content/", "/content/", $activity->link . "/embed");
        return view('admin.activities.show', compact('activity', 'embedLink'));
    }
    
    

    // Mostrar el formulario para editar una actividad existente
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $topics = Topic::all(); 
        return view('admin.activities.edit', compact('activity', 'topics'));
    }

    // Actualizar una actividad existente
    public function update(Request $request, Activity $activity)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'required|url',
            'status' => 'boolean',
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Actualizar la actividad
        $activity->update($request->all());

        return redirect()->route('activities.index')->with('success', 'Actividad actualizada exitosamente');
    }

    // Eliminar una actividad existente
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Actividad eliminada exitosamente');
    }
}
