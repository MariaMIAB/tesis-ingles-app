<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAnswer;
use App\Models\Exam;

class UserAnswerController extends Controller
{
    public function index(Exam $exam)
    {
        $userAnswers = $exam->userAnswers;
        return view('admin.userAnswers.index', compact('exam', 'userAnswers'));
    }

    public function create(Exam $exam)
    {
        return view('admin.userAnswers.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $userAnswer = new UserAnswer();
        $userAnswer->exam_id = $exam->id;
        $userAnswer->question_id = $request->question_id;
        $userAnswer->user_id = $request->user_id;
        $userAnswer->answer = $request->answer;
        $userAnswer->save();

        return redirect()->route('admin.exams.userAnswers.index', $exam);
    }

    public function show(Exam $exam, UserAnswer $userAnswer)
    {
        return view('admin.userAnswers.show', compact('exam', 'userAnswer'));
    }

    public function edit(Exam $exam, UserAnswer $userAnswer)
    {
        return view('admin.userAnswers.edit', compact('exam', 'userAnswer'));
    }

    public function update(Request $request, Exam $exam, UserAnswer $userAnswer)
    {
        $userAnswer->question_id = $request->question_id;
        $userAnswer->user_id = $request->user_id;
        $userAnswer->answer = $request->answer;
        $userAnswer->save();

        return redirect()->route('admin.exams.userAnswers.index', $exam);
    }

    public function destroy(Exam $exam, UserAnswer $userAnswer)
    {
        $userAnswer->delete();

        return redirect()->route('admin.exams.userAnswers.index', $exam);
    }
}
