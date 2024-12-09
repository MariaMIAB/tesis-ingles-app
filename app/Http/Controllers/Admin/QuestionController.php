<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Option;

class QuestionController extends Controller
{
    public function create($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        return view('admin.questions.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.content' => 'required|string',
            'questions.*.type' => 'required|string|in:multiple_choice,true_false,short_answer',
            'questions.*.answer' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'nullable|string',
        ]);

        foreach ($validated['questions'] as $questionData) {
            $question = new Question([
                'content' => $questionData['content'],
                'type' => $questionData['type'],
                'exam_id' => $exam->id,
            ]);
            $question->save();

            // Manejar diferentes tipos de preguntas
            if ($questionData['type'] === 'multiple_choice' && isset($questionData['options'])) {
                foreach ($questionData['options'] as $optionContent) {
                    $option = $question->options()->create(['content' => $optionContent]);

                    // Marcar la opción correcta
                    if (isset($questionData['correct_answer']) && $questionData['correct_answer'] === $optionContent) {
                        $option->is_correct = true;
                        $option->save();
                    }
                }
            } elseif ($questionData['type'] === 'true_false' || $questionData['type'] === 'short_answer') {
                if (isset($questionData['answer'])) {
                    $question->answers()->create(['content' => $questionData['answer']]);
                }
            }
        }

        return redirect()->route('exams.show', $exam)->with('success', 'Preguntas añadidas exitosamente.');
    }

    public function edit($exam)
    {
        // Cargar el examen, las preguntas y las respuestas asociadas
        $exam = Exam::with('questions.answers')->findOrFail($exam);
        $questions = $exam->questions; // Ahora cada pregunta tendrá su propiedad 'answers'

        return view('admin.questions.edit', compact('exam', 'questions'));
    }

    public function update(Request $request, $exam)
    {
        $request->validate([
            'questions.*.content' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,true_false,short_answer',
            'questions.*.answer' => 'required_if:questions.*.type,true_false,short_answer|string',
            'questions.*.options' => 'required_if:questions.*.type,multiple_choice|array|min:2',
            'questions.*.options.*' => 'required|string',
        ]);
        
        $exam = Exam::findOrFail($exam);
        $questionsData = $request->input('questions');
        
        foreach ($questionsData as $questionId => $questionData) {
            $question = $exam->questions()->find($questionId);
            
            if ($question) {
                // Actualizar la pregunta
                $question->update([
                    'content' => $questionData['content'],
                    'type' => $questionData['type'],
                ]);
    
                // Si la pregunta es de tipo "multiple_choice"
                if ($question->type == 'multiple_choice') {
                    // Eliminar las opciones existentes
                    $question->options()->delete();
    
                    // Insertar nuevas opciones
                    foreach ($questionData['options'] as $optionContent) {
                        $question->options()->create(['content' => $optionContent]);
                    }
                }
    
                // Si la pregunta es de tipo "true_false"
                if ($question->type == 'true_false') {
                    $question->answers()->update(['content' => $questionData['answer']]);
                }
    
                // Si la pregunta es de tipo "short_answer"
                if ($question->type == 'short_answer') {
                    $question->answers()->update(['content' => $questionData['answer']]);
                }
            }
        }
    
        return redirect()->route('exams.show', $exam)->with('success', 'Preguntas actualizados exitosamente.');
    }
    
}





