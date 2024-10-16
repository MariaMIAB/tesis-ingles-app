<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Semester\StoreRequest;
use App\Models\Semester;
use App\Models\Year;
use Illuminate\Http\Request;

class SemesterController extends Controller
{

    public function create($id)
    {
        $year = Year::findOrFail($id);
        $semesters = $year->semesters; 
    
        return view('admin.semester.create', compact('year', 'semesters')); 
    }
    
    public function storeOrUpdate(StoreRequest $request)
    {
        $year = Year::findOrFail($request->year_id);

        $semesterNames = ['Primer Semestre', 'Segundo Semestre', 'Tercer Semestre'];

        foreach ($request->semesters as $index => $semesterData) {
            if (!empty($semesterData['start_date']) && !empty($semesterData['end_date'])) {
                Semester::updateOrCreate(
                    [
                        'year_id' => $year->id,
                        'name' => $semesterNames[$index] ?? 'Semestre ' . ($index + 1)
                    ],
                    [
                        'start_date' => $index === 0 ? $year->start_date : $semesterData['start_date'],
                        'end_date' => $index === 2 ? $year->end_date : $semesterData['end_date'],
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Semestres guardados exitosamente.');
    }
}