<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }
        //dd($request);
        // Validación de los datos
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'score' => 'required|numeric|min:0|max:100',
        ], [
            'activity_id.required' => 'El ID de la actividad es obligatorio.',
            'activity_id.exists' => 'La actividad seleccionada no es válida.',
            'score.required' => 'El puntaje es obligatorio.',
            'score.integer' => 'El puntaje debe ser un número entero.',
            'score.min' => 'El puntaje mínimo permitido es 0.',
            'score.max' => 'El puntaje máximo permitido es 100.',
        ]);
    
        $user = Auth::user();
        $activityId = $request->activity_id;
        $score = intval($request->score);
        
        // Verificar si el usuario ya registró esta actividad
        if (UserActivity::where('user_id', $user->id)->where('activity_id', $activityId)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Ya realizaste esta actividad.']);
        }
    
        // Guardar el progreso de la actividad
        UserActivity::create([
            'user_id' => $user->id,
            'activity_id' => $activityId,
            'score' => $score,
            'status' => 'completed',
            'started_at' => now(),
            'completed_at' => now(),
        ]);
    
        // Redirigir a la actividad con mensaje de éxito
        return redirect()->route('activitiesu.show', $activityId)->with('success', 'Progreso guardado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity = Activity::with('topic')->findOrFail($id);
        $embedLink = null;
    
        if (!empty($activity->link)) {
            $embedLink = asset($activity->link);
        }
    
        // Buscar si el usuario ha completado la actividad
        $userActivity = UserActivity::where('user_id', auth()->id())
            ->where('activity_id', $activity->id)
            ->first();
    
        $isCompleted = $userActivity && $userActivity->status === 'completed';
    
        return view('web.activities.show', compact('activity', 'embedLink', 'isCompleted', 'userActivity'));
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
