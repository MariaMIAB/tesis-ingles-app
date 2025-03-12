<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserExamController extends Controller
{
    public function show(Exam $exam)
    {
        $userExam = Auth::user()->examsTaken()->where('exam_id', $exam->id)->first();

        if (!$userExam) {
            return view('web.exams.show', compact('exam'));
        }

        $score = $userExam->pivot->score;
        $userAnswers = UserAnswer::whereIn('question_id', $exam->questions->pluck('id'))
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('question_id');

        $correctAnswers = [];
        $results = [];
        $correctCount = 0;

        foreach ($exam->questions as $question) {
            $correctAnswer = null;

            if ($question->type === 'multiple_choice') {
                $correctAnswer = $question->options()->where('is_correct', true)->first();
            } elseif (in_array($question->type, ['true_false', 'short_answer'])) {
                $correctAnswer = $question->answers()->first();
            }

            $correctAnswers[$question->id] = $correctAnswer;
            $userAnswer = $userAnswers->get($question->id);

            if ($userAnswer && $correctAnswer && is_object($correctAnswer)) {
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
        $attemptResults = $this->getLastThreeAttempts($exam);
       // dd($attemptResults);

        return view('web.exams.results', compact('exam', 'userExam', 'userAnswers', 'correctAnswers', 'results', 'score', 'correctCount', 'attemptResults'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $userId = Auth::id();
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $totalQuestions = $exam->questions->count();
        $correctAnswers = 0;
        $pointsPerCorrectAnswer = 100 / $totalQuestions;

        foreach ($exam->questions as $question) {
            $answerContent = $validated['answers'][$question->id] ?? null;
            $isCorrect = false;

            if ($answerContent) {
                switch ($question->type) {
                    case 'multiple_choice':
                        $selectedOption = $question->options()->find($answerContent);
                        if ($selectedOption && $selectedOption->is_correct) {
                            $isCorrect = true;
                        }
                        break;
                    case 'true_false':
                    case 'short_answer':
                        $correctAnswer = $question->answers()->first();
                        if ($correctAnswer && is_object($correctAnswer) && strtolower($correctAnswer->content) === strtolower($answerContent)) {
                            $isCorrect = true;
                        }
                        break;
                }
            }

            if ($isCorrect) {
                $correctAnswers++;
            }

            UserAnswer::updateOrCreate(
                ['user_id' => $userId, 'question_id' => $question->id],
                ['answer' => $answerContent, 'is_correct' => $isCorrect]
            );
        }

        $score = round($correctAnswers * $pointsPerCorrectAnswer);
        UserExam::updateOrCreate(
            ['user_id' => $userId, 'exam_id' => $exam->id],
            ['score' => $score]
        );

        return redirect()->route('topicsu.index')->with('success',
            'Examen enviado exitosamente. Tu calificación es: ' . $score . '% (' . $correctAnswers . ' de ' . $totalQuestions . ' respuestas correctas).');
    }

    private function getLastThreeAttempts(Exam $exam)
    {
        $userId = Auth::id();
        $examId = $exam->id;
    
        // Obtener los últimos tres intentos
        $attempts = DB::table('user_exams')
            ->where('user_id', $userId)
            ->where('exam_id', $examId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($attempt) {
                return (array) $attempt; // Convertimos cada objeto en array
            });
    
        // Determinar la mejor nota
        $bestScore = $attempts->max('score'); // 🔹 Encuentra la mejor nota
    
        // Agregar la clave "is_best"
        $attempts = $attempts->map(function ($attempt) use ($bestScore) {
            $attempt['is_best'] = ($attempt['score'] == $bestScore); // 🔹 Marca el mejor intento
            return $attempt;
        });
    
        return $attempts;
    }
    
    

}