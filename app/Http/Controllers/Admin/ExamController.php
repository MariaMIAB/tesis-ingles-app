<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Semester;
use App\Models\Topic;
use App\Models\Year;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    // Método para obtener los exámenes en formato DataTable
    public function datatables()
    {
        $exams = Exam::with('topic')->select('exams.*');

        return DataTables::eloquent($exams)
            ->addColumn('topic_name', function (Exam $exam) {
                return $exam->topic->topic_name; // Corregir nombre de la propiedad 'topic_name'
            })
            ->addColumn('btn', 'admin.exams.partials.btn') // Asumimos que 'btn' está en la carpeta 'partials'
            ->rawColumns(['btn'])
            ->toJson();
    }

    // Método para mostrar la lista de exámenes
    public function index()
    {
        $exams = Exam::with('topic')->get(); // Se asegura de obtener los exámenes con la relación de 'topic'
        return view('admin.exams.index', compact('exams'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        $topics = Topic::all();
        $years = Year::with('semesters')->get(); // Obtener años con semestres
        return view('admin.exams.create', compact('topics', 'years'));
    }

    // Método para almacenar un nuevo examen
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:true_false,short_answer,multiple_choice,varied',
            'duration' => 'required|integer|max:60',
            'topic_id' => 'required|exists:topics,id',
            'semester_id' => 'required|exists:semesters,id',
            'description' => 'nullable|string',
            'visibility' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);

        // Crear el examen
        Exam::create([
            'title' => $validatedData['title'],
            'type' => $validatedData['type'],
            'duration' => $validatedData['duration'],
            'topic_id' => $validatedData['topic_id'],
            'semester_id' => $validatedData['semester_id'],
            'description' => $validatedData['description'],
            'visibility' => $validatedData['visibility'],
            'published_at' => $validatedData['published_at'],
        ]);

        return redirect()->route('exams.index')->with('success', 'Examen creado exitosamente.');
    }

    // Método para mostrar los detalles de un examen
    public function show($id)
    {
        $exam = Exam::with('topic', 'semester', 'year', 'questions.options', 'questions.answers')
            ->findOrFail($id);
        return view('admin.exams.show', compact('exam'));
    }

    // Método para mostrar el formulario de edición de un examen
    public function edit(Exam $exam)
    {
        $years = Year::all();
        $topics = Topic::all();
        $semesters = Semester::where('year_id', $exam->year_id)->get();
        return view('admin.exams.edit', compact('exam', 'years', 'topics', 'semesters'));
    }

    // Método para actualizar un examen existente
    public function update(Request $request, Exam $exam)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:true_false,short_answer,multiple_choice,varied',
            'duration' => 'required|integer|max:60',
            'topic_id' => 'required|exists:topics,id',
            'semester_id' => 'required|exists:semesters,id',
            'description' => 'nullable|string',
            'visibility' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);

        // Actualizar el examen
        $exam->update($validatedData);

        return redirect()->route('exams.index')->with('success', 'Examen actualizado exitosamente.');
    }

    // Método para eliminar un examen
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Examen eliminado exitosamente.');
    }
}

