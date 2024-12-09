<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\UserAnswer;
use App\Models\UserExam; // Asegúrate de tener un modelo para guardar las calificaciones
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserExamController extends Controller
{
    public function show(Exam $exam)
    {
        // Obtener el examen tomado por el usuario
        $userExam = Auth::user()->examsTaken()->where('exam_id', $exam->id)->first();

        // Si el usuario no ha tomado el examen, redirigirlo
        if (!$userExam) {
            return redirect()->route('exams.take', $exam->id);
        }

        $score = $userExam->pivot->score;

        // Obtener las respuestas del usuario desde la tabla UserAnswer, usando question_id
        $userAnswers = UserAnswer::whereIn('question_id', $exam->questions->pluck('id'))
                                ->where('user_id', Auth::id())
                                ->get()
                                ->keyBy('question_id'); // Usamos keyBy para acceder a las respuestas por question_id fácilmente

        // Inicializar el array para almacenar las respuestas correctas
        $correctAnswers = [];
        $correctCount = 0; // Variable para contar las respuestas correctas

        foreach ($exam->questions as $question) {
            // Verificar si la pregunta tiene opciones y obtener la respuesta correcta
            if ($question->type == 'multiple_choice') {
                $correctAnswers[$question->id] = $question->options()->where('is_correct', true)->first();
            }
            // Si la pregunta es de tipo verdadero/falso o respuesta corta, obtenemos la respuesta correcta
            elseif ($question->type == 'true_false' || $question->type == 'short_answer') {
                $correctAnswers[$question->id] = $question->answers()->first();
            }

            // Verificar si la respuesta del usuario es correcta y contar
            if (isset($userAnswers[$question->id]) && $userAnswers[$question->id]->answer == $correctAnswers[$question->id]->content) {
                $correctCount++; // Incrementamos el contador de respuestas correctas
            }
        }

        // Pasar los datos a la vista
        return view('web.exams.results', compact('exam', 'userExam', 'userAnswers', 'correctAnswers', 'score', 'correctCount'));
    }

    
    public function submit(Request $request, Exam $exam)
    {
        $userId = Auth::id();
        // Validar que todas las preguntas tienen respuesta
        $validated = $request->validate([
            'answers' => 'required|array', // La respuesta debe ser un arreglo
        ]);
    
        // Inicializar las variables para el cálculo de la calificación
        $totalQuestions = $exam->questions->count();  // Total de preguntas
        $correctAnswers = 0;  // Respuestas correctas
        $pointsPerCorrectAnswer = 100 / $totalQuestions;  // Puntaje por respuesta correcta
    
        // Recorrer las preguntas y guardar las respuestas
        foreach ($exam->questions as $question) {
            // Obtener la respuesta seleccionada por el usuario (puede ser option_id o texto)
            $answerContent = $validated['answers'][$question->id] ?? null;
    
            if ($answerContent) {
                $isCorrect = false;  // Asumir que la respuesta es incorrecta
    
                // Comprobación según el tipo de pregunta
                switch ($question->type) {
                    case 'multiple_choice': // Opción múltiple
                        // Buscar la opción seleccionada por el usuario (suponiendo que 'answerContent' es el ID de la opción)
                        $selectedOption = $question->options()->find($answerContent);
    
                        // Verificar si la opción seleccionada es correcta (is_correct = 1)
                        if ($selectedOption && $selectedOption->is_correct == 1) {
                            $isCorrect = true;
                        }
    
                        // Guardar la respuesta del usuario en 'option_id' para preguntas de opción múltiple
                        UserAnswer::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'question_id' => $question->id,
                            ],
                            [
                                'option_id' => $answerContent,  // Guardamos el option_id en lugar de 'answer'
                                'answer' => $isCorrect,     // Guardamos si la respuesta fue correcta
                            ]
                        );
    
                        // Si la respuesta fue correcta, aumentar el contador
                        if ($isCorrect) {
                            $correctAnswers++;
                        }
                        break;
    
                    case 'true_false': // Verdadero/Falso
                        // Buscar la respuesta correcta en la tabla 'answers'
                        $correctAnswer = $question->answers()->first(); // Suponiendo que solo hay una respuesta correcta
                        if ($correctAnswer && strtolower($correctAnswer->content) == strtolower($answerContent)) {
                            $isCorrect = true;
                        }
    
                        // Guardar la respuesta del usuario en 'answer' para Verdadero/Falso
                        UserAnswer::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'question_id' => $question->id,
                            ],
                            [
                                'answer' => $answerContent,    // Guardamos la respuesta textual
                                'is_correct' => $isCorrect,    // Guardamos si la respuesta fue correcta
                            ]
                        );
    
                        // Si la respuesta fue correcta, aumentar el contador
                        if ($isCorrect) {
                            $correctAnswers++;
                        }
                        break;
    
                    case 'short_answer': // Respuesta corta
                        // Buscar la respuesta correcta en la tabla 'answers'
                        $correctAnswer = $question->answers()->first(); // Suponiendo que solo hay una respuesta correcta
                        if ($correctAnswer && strtolower($correctAnswer->content) == strtolower($answerContent)) {
                            $isCorrect = true;
                        }
    
                        // Guardar la respuesta del usuario en 'answer' para respuesta corta
                        UserAnswer::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'question_id' => $question->id,
                            ],
                            [
                                'answer' => $answerContent,    // Guardamos la respuesta textual para respuestas cortas
                                'is_correct' => $isCorrect,    // Guardamos si la respuesta fue correcta
                            ]
                        );
    
                        // Si la respuesta fue correcta, aumentar el contador
                        if ($isCorrect) {
                            $correctAnswers++;
                        }
                        break;
    
                    default:
                        // Si el tipo de pregunta no es reconocido, asume que la respuesta es incorrecta
                        $isCorrect = false;
                        break;
                }
            }
        }
    
        // Calcular la calificación basada en las respuestas correctas
        $score = round($correctAnswers * $pointsPerCorrectAnswer);  // Puntaje total basado en las respuestas correctas
    
        // Guardar la calificación en la tabla 'user_exams'
        UserExam::updateOrCreate(
            [
                'user_id' => $userId,
                'exam_id' => $exam->id,
            ],
            [
                'score' => $score,
            ]
        );
    
        // Redirigir con mensaje de éxito mostrando la cantidad de respuestas correctas y el puntaje
        return redirect()->route('topicsu.index')->with('success', 
            'Examen enviado exitosamente. Tu calificación es: ' . $score . '% (' . $correctAnswers . ' de ' . $totalQuestions . ' respuestas correctas).');
    }
    
    public function showResults($exam_id)
    {
        // Obtener el examen tomado por el usuario
        $userExam = Auth::user()->examsTaken()->where('exam_id', $exam->id)->first();
    
        // Si el usuario no ha tomado el examen, redirigirlo
        if (!$userExam) {
            return redirect()->route('exams.take', $exam->id);
        }
    
        // Obtener las respuestas del usuario (suponiendo que las respuestas están almacenadas en UserAnswer)
        $userAnswers = UserAnswer::where('exam_id', $exam->id)
                                ->where('user_id', Auth::id())
                                ->get();
    
        // Obtener las respuestas correctas para las preguntas
        $correctAnswers = [];
        foreach ($exam->questions as $question) {
            // Si la pregunta tiene opciones, usamos la opción correcta
            if ($question->type == 'multiple_choice') {
                $correctAnswers[$question->id] = $question->options()->where('is_correct', true)->first();
            }
            // Si la pregunta tiene una respuesta corta o de verdadero/falso, la respuesta correcta está en Answer
            elseif ($question->type == 'true_false' || $question->type == 'short_answer') {
                $correctAnswers[$question->id] = $question->answers()->first();
            }
        }
    
        // Pasar los datos a la vista
        return view('web.exams.results', compact('exam', 'userExam', 'userAnswers', 'correctAnswers'));
    }
    
    
}





