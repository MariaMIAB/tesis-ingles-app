<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Activity;
use App\Models\Semester;
use App\Models\Topic;
use App\Models\TopicLike;
use App\Models\TopicView;
use App\Models\Year;

class PanelController extends Controller
{
    /**
     * Muestra el panel de administración con datos generales.
     */
    public function index(Request $request)
    {
        // Datos generales
        $totalUsers = User::count();
        $totalExams = Exam::count();
        $totalActivities = Activity::count();
        $totalTopics = Topic::count();
        $totalSemesters = Semester::count();
        $totalLikes = TopicLike::count();
        $totalViews = TopicView::count();
    
        // Obtener los años disponibles basados en la tabla "years"
        $availableYears = Year::pluck('name', 'id'); 
        
        // Obtener el año seleccionado desde la vista o el más reciente por defecto
        $selectedYearId = $request->input('year', Year::orderBy('name', 'desc')->first()->id);
    
        // Obtener los datos por semestre para el año seleccionado
        $formattedSemesterData = $this->getSemesterData($selectedYearId);
    
        // Obtener los temas con más vistas y más likes
        $mostViewedTopics = Topic::withCount('views')
            ->orderByDesc('views_count')
            ->take(5)
            ->get(['id', 'topic_name']);
    
        $mostLikedTopics = Topic::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get(['id', 'topic_name']);
    
        // Pasar las variables a la vista
        return view('admin.panel', compact(
            'totalUsers', 'totalExams', 'totalActivities', 'totalTopics', 
            'totalSemesters', 'totalLikes', 'totalViews', 'mostViewedTopics', 'mostLikedTopics',
            'formattedSemesterData', 'availableYears', 'selectedYearId'
        ));
    }

    /**
     * Devuelve los datos por semestre en formato JSON para el filtrado dinámico.
     */
    public function filterSemesterData(Request $request)
    {
        $yearId = $request->input('year_id');
        $formattedSemesterData = $this->getSemesterData($yearId);
        return response()->json($formattedSemesterData);
    }

    /**
     * Obtiene los datos formateados de semestres de acuerdo con el año proporcionado.
     */
    private function getSemesterData($yearId)
    {
        $semesters = Semester::where('year_id', $yearId)->get();

        return $semesters->map(function ($semester) {
            $topics = $semester->topics()->withCount(['exams', 'activities'])->get();

            return [
                'semester' => $semester->name,
                'topics' => $topics->count(),
                'exams' => $topics->sum('exams_count'),
                'activities' => $topics->sum('activities_count')
            ];
        });
    }
}
