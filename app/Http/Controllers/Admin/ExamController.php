<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Topic;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    public function datatables()
    {
        $exams = Exam::with('topic')->select('exams.*');

        return DataTables::eloquent($exams)
            ->addColumn('topic_name', function (Exam $exam) {
                return $exam->topic->name;
            })
            ->addColumn('btn', 'admin.exams.partials.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function index()
    {
        $exams = Exam::all();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $topics = Topic::all();
        return view('admin.exams.create', compact('topics'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic_id' => 'required|integer',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'visibility' => 'required|boolean',
            'duration' => 'required|integer',
        ]);

        $exam = Exam::create([
            'title' => $validated['title'],
            'topic_id' => $validated['topic_id'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'visible' => $validated['visibility'],
            'duration' => $validated['duration'],
        ]);

        return redirect()->route('exams.index')->with('success', 'Examen creado exitosamente.');
    }

    public function show($id)
    {
        $exam = Exam::with('questions.options', 'questions.answers')->findOrFail($id);
        return view('admin.exams.show', compact('exam'));
    }
    
    public function edit(Exam $exam)
    {
        $topics = Topic::all();
        return view('admin.exams.edit', compact('exam', 'topics'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
            'visibility' => 'required|boolean',
            'duration' => 'required|integer',
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')->with('success', 'Examen actualizado exitosamente');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Examen eliminado exitosamente');
    }
}
