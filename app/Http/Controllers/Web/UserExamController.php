<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserExamController extends Controller
{
    public function show(Exam $exam)
    {
        // Obtener el examen tomado por el usuario
        $userExam = Auth::user()->examsTaken()->where('exam_id', $exam->id)->first();

        if (!$userExam) {
            return view('web.exams.show', compact('exam'));
        }

        $score = $userExam->pivot->score;

        // Obtener las respuestas del usuario
        $userAnswers = UserAnswer::whereIn('question_id', $exam->questions->pluck('id'))
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('question_id');

        // Inicializar datos para las respuestas correctas
        $correctAnswers = [];
        $results = [];
        $correctCount = 0;

        foreach ($exam->questions as $question) {
            $correctAnswer = null;

            // Obtener la respuesta correcta
            if ($question->type === 'multiple_choice') {
                $correctAnswer = $question->options()->where('is_correct', true)->first();
            } elseif (in_array($question->type, ['true_false', 'short_answer'])) {
                $correctAnswer = $question->answers()->first();
            }

            $correctAnswers[$question->id] = $correctAnswer;

            // Obtener la respuesta del usuario
            $userAnswer = $userAnswers->get($question->id);

            if ($userAnswer && $correctAnswer) {
                if ($question->type === 'multiple_choice') {
                    $results[$question->id] = (int) $userAnswer->answer === (int) $correctAnswer->id;
                } else {
                    $results[$question->id] = strtolower(trim($userAnswer->answer)) === strtolower(trim($correctAnswer->content));
                }

                if ($results[$question->id]) {
                    $correctCount++;
                }
            } else {
                $results[$question->id] = false;
            }
        }

        return view('web.exams.results', compact('exam', 'userExam', 'userAnswers', 'correctAnswers', 'results', 'score', 'correctCount'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $userId = Auth::id();

        // Validar las respuestas enviadas
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $totalQuestions = $exam->questions->count();
        $correctAnswers = 0;
        $pointsPerCorrectAnswer = 100 / $totalQuestions;

        foreach ($exam->questions as $question) {
            $answerContent = $validated['answers'][$question->id] ?? null;

            if ($answerContent) {
                $isCorrect = false;

                switch ($question->type) {
                    case 'multiple_choice':
                        $selectedOption = $question->options()->find($answerContent);

                        if ($selectedOption && $selectedOption->is_correct) {
                            $isCorrect = true;
                        }

                        UserAnswer::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'question_id' => $question->id,
                            ],
                            [
                                'answer' => $answerContent,
                            ]
                        );

                        break;

                    case 'true_false':
                    case 'short_answer':
                        $correctAnswer = $question->answers()->first();

                        if ($correctAnswer && strtolower($correctAnswer->content) === strtolower($answerContent)) {
                            $isCorrect = true;
                        }

                        UserAnswer::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'question_id' => $question->id,
                            ],
                            [
                                'answer' => $answerContent,
                                'is_correct' => $isCorrect,
                            ]
                        );

                        break;
                }

                if ($isCorrect) {
                    $correctAnswers++;
                }
            }
        }

        $score = round($correctAnswers * $pointsPerCorrectAnswer);

        UserExam::updateOrCreate(
            [
                'user_id' => $userId,
                'exam_id' => $exam->id,
            ],
            [
                'score' => $score,
            ]
        );

        return redirect()->route('topicsu.index')->with('success', 
            'Examen enviado exitosamente. Tu calificación es: ' . $score . '% (' . $correctAnswers . ' de ' . $totalQuestions . ' respuestas correctas).');
    }

    public function showResults($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        $userExam = Auth::user()->examsTaken()->where('exam_id', $exam->id)->first();

        if (!$userExam) {
            return redirect()->route('exams.take', $exam->id);
        }

        $userAnswers = UserAnswer::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('question_id');

        $results = [];
        $correctCount = 0;

        foreach ($exam->questions as $question) {
            $correctAnswer = null;

            if ($question->type === 'multiple_choice') {
                $correctAnswer = $question->options()->where('is_correct', true)->first();
            } elseif (in_array($question->type, ['true_false', 'short_answer'])) {
                $correctAnswer = $question->answers()->first();
            }

            $userAnswer = $userAnswers->get($question->id);

            if ($userAnswer && $correctAnswer) {
                if ($question->type === 'multiple_choice') {
                    $results[$question->id] = (int) $userAnswer->answer === (int) $correctAnswer->id;
                } else {
                    $results[$question->id] = strtolower(trim($userAnswer->answer)) === strtolower(trim($correctAnswer->content));
                }

                if ($results[$question->id]) {
                    $correctCount++;
                }
            } else {
                $results[$question->id] = false;
            }
        }

        return view('web.exams.results', compact('exam', 'userExam', 'userAnswers', 'results', 'correctCount'));
    }
}





