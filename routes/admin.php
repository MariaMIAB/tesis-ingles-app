<?php

use App\Http\Controllers\Admin\BackupController;
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

    //rutas de backups
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::post('/backups/download', [BackupController::class, 'download'])->name('backups.download');

});