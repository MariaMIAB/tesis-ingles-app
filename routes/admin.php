<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\UserController;

Route::get('admin', function(){
    return ('hola');
});

//panel de administracion
Route::group(['middleware' => ['role:Administrador|Profesor']], function () {
Route::get('/panel',[PanelController::class,'index'])->name('panel');

//rutas de tablas
Route::get('api/dbusers', [UserController::class, 'datatables']);
Route::resource('user', UserController::class);
});