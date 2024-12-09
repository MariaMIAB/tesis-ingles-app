<?php

use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\ElevenLabsController;
use App\Http\Controllers\web\UserExamController;
use App\Http\Controllers\Web\ActivityController;
use App\Http\Controllers\Web\TopicController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
});

Route::get('/topicsu', [TopicController::class, 'index'])->name('topicsu.index');
Route::get('/topicsu/{id}', [TopicController::class, 'show'])->name('topicsu.show');
Route::get('/activitiesu/{id}', [ActivityController::class, 'show'])->name('activitiesu.show');
Route::get('/text-to-speech/{contentId}', [ElevenLabsController::class, 'textToSpeech']);
Route::get('/exam/{exam}', [UserExamController::class, 'show'])->name('exam.show');
Route::post('/exam/{exam}', [UserExamController::class, 'submit'])->name('exam.submit');
Route::get('/exam/{exam_id}/results', [UserExamController::class, 'showResults'])->name('exam.results');



Auth::routes();

