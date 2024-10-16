<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\HomeController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Redirect;

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

Auth::routes();

