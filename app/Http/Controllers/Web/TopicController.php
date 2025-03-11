<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('activities', 'exams')->with('contents')->get();
        return view('web.topics.index', compact('topics'));
    }
    
    public function show($id)
    {
        $topic = Topic::with(['contents', 'activities'])->findOrFail($id);
        $searchQuery = $topic->topic_name;
        $recommendations = $this->fetchAcademicContent($searchQuery);

        return view('web.topics.show', compact('topic', 'recommendations'));
    }
    
    /**
     * Busca contenido académico basado en un título de tema.
     */
    private function fetchAcademicContent($query)
    {
        $apiUrl = "https://api.semanticscholar.org/graph/v1/paper/search?query=" . urlencode($query) . "&limit=5";

        try {
            $response = Http::get($apiUrl);
            $data = $response->json();

            $recommendations = collect($data['data'])->map(function ($item) {
                return (object) [
                    'title' => $item['title'] ?? 'Artículo sin título',
                    'summary' => $item['abstract'] ?? 'Sin resumen disponible.',
                    'url' => isset($item['url']) ? $item['url'] : "https://scholar.google.com/scholar?q=" . urlencode($item['title']),
                ];
            })->toArray();

            // Si no hay recomendaciones, agregar un mensaje
            if (empty($recommendations)) {
                return [(object) [
                    'title' => 'No hay recomendaciones para este tema',
                    'summary' => '',
                    'url' => '#'
                ]];
            }

            return $recommendations;
        } catch (\Exception $e) {
            return [(object) [
                'title' => 'No hay recomendaciones para este tema',
                'summary' => '',
                'url' => '#'
            ]];
        }
    }
}
