<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Topic;

class TopicController extends Controller
{
    // Método para listar todos los temas
    public function index()
    {
        $topics = Topic::withCount('activities', 'exams')->with('contents')->get();
        return view('web.topics.index', compact('topics'));
    }
    

    // Método para mostrar un tema específico junto con sus contenidos
    public function show($id)
    {
        // Cargar el tema con sus contenidos y actividades
        $topic = Topic::with(['contents', 'activities'])->findOrFail($id);
        return view('web.topics.show', compact('topic'));
    }
}
