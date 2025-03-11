<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Year\StoreRequest;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yajra\DataTables\Facades\DataTables;

class YearController extends Controller
{
    public function datatables(){
        return DataTables::eloquent(Year::query())
        ->addColumn('btn', 'admin.years.partials.btn')
        ->rawColumns(['btn'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('admin.years.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Year::create($request->validated());

        return redirect()->route('years.index')->with('success', 'Año escolar creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Year $year)
    {
        $students = \App\Models\User::whereHas('semesters', function ($query) use ($year) {
            $query->whereIn('semester_id', $year->semesters->pluck('id'));
        })->with(['activities', 'exams'])->get();
    
        $studentScores = $this->getStudentScores($year, $students);
    
        return view('admin.years.show', compact('year', 'students', 'studentScores'));
    }
    
    private function getStudentScores(Year $year, $students)
    {
        $year->load(['semesters.topics.activities', 'semesters.topics.exams']);
    
        $topics = $year->semesters->flatMap->topics;
        $activities = $topics->flatMap->activities;
        $exams = $topics->flatMap->exams;
    
        $userActivityScores = \App\Models\UserActivity::whereIn('activity_id', $activities->pluck('id'))->get();
        $userExamScores = \App\Models\UserExam::whereIn('exam_id', $exams->pluck('id'))->get();
    
        $studentScores = [];
    
        foreach ($students as $student) {
            $totalEstimatedFinal = 0;
            $countEstimatedFinal = 0;
            
            foreach ($year->semesters as $semester) {
                $semesterTopics = $topics->where('semester_id', $semester->id);
                $semesterActivities = $activities->whereIn('topic_id', $semesterTopics->pluck('id'));
                $semesterExams = $exams->whereIn('topic_id', $semesterTopics->pluck('id'));
    
                $activityScores = $userActivityScores->where('user_id', $student->id)
                                                    ->whereIn('activity_id', $semesterActivities->pluck('id'))
                                                    ->pluck('score');
    
                $examScores = $userExamScores->where('user_id', $student->id)
                                            ->whereIn('exam_id', $semesterExams->pluck('id'))
                                            ->pluck('score');
    
                $activityScore = $activityScores->isNotEmpty() ? $activityScores->avg() : null;
                $examScore = $examScores->isNotEmpty() ? $examScores->avg() : null;
    
                $totalScore = (!is_null($activityScore) && !is_null($examScore))
                    ? ($activityScore + $examScore) / 2
                    : null;
    
                $activityWithZero = $activityScore ?? 0;
                $examWithZero = $examScore ?? 0;
                $estimatedTotal = ($activityWithZero + $examWithZero) / 2;
                
                $totalEstimatedFinal += $estimatedTotal;
                $countEstimatedFinal++;
                
                $studentScores[$student->id][$semester->id] = [
                    'activities' => $activityScore,
                    'exams' => $examScore,
                    'total' => $totalScore,
                    'estimated' => $estimatedTotal,
                ];
            }
            
            $studentScores[$student->id]['final_estimated'] = $countEstimatedFinal > 0 
                ? $totalEstimatedFinal / $countEstimatedFinal 
                : null;
        }
    
        return $studentScores;
    }
    

    public function getSemesters($yearId)
    {
        $year = Year::with('semesters')->findOrFail($yearId); // Carga los semestres relacionados
        return response()->json($year->semesters);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Year $year)
    {
        return view('admin.years.edit', compact('year'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Year $year)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $year->update($request->all());

        return redirect()->route('years.index')->with('success', 'Año escolar actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year)
    {
        $year->delete();

        return redirect()->route('years.index')->with('success', 'Año escolar eliminado exitosamente.');
    }
}
