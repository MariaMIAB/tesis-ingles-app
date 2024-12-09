<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Question;

class OptionController extends Controller
{
    public function index(Question $question)
    {
        $options = $question->options;
        return view('admin.options.index', compact('question', 'options'));
    }

    public function create(Question $question)
    {
        return view('admin.options.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $option = new Option();
        $option->question_id = $question->id;
        $option->content = $request->content;
        $option->is_correct = $request->is_correct; // Indica si es la opción correcta
        $option->save();

        return redirect()->route('admin.questions.options.index', $question);
    }

    public function show(Question $question, Option $option)
    {
        return view('admin.options.show', compact('question', 'option'));
    }

    public function edit(Question $question, Option $option)
    {
        return view('admin.options.edit', compact('question', 'option'));
    }

    public function update(Request $request, Question $question, Option $option)
    {
        $option->content = $request->content;
        $option->is_correct = $request->is_correct;
        $option->save();

        return redirect()->route('admin.questions.options.index', $question);
    }

    public function destroy(Question $question, Option $option)
    {
        $option->delete();

        return redirect()->route('admin.questions.options.index', $question);
    }
}
