<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;


Route::group(['middleware' => ['role:Administrador|Profesor']], function () {


    //panel de administracion
    Route::get('/panel',[PanelController::class,'index'])->name('panel');

    //rutas principales
    Route::resources([
        'users' => UserController::class,
        'roles' => RoleController::class
    ]);

    //rutas de tablas
    Route::get('api/dbusers', [UserController::class, 'datatables']);
    Route::get('api/dbroles', [RoleController::class, 'datatables']);
});