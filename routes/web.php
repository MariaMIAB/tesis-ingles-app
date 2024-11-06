<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\HomeController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ElevenLabsController;
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

Route::get('/text-to-speech/{contentId}', [ElevenLabsController::class, 'textToSpeech']);



Auth::routes();

