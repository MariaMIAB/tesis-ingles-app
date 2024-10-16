<?php

use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YearController;
use App\Http\Controllers\Admin\SemesterController;

Route::group(['middleware' => ['role:Administrador|Profesor']], function () {

    //panel de administracion
    Route::get('/panel',[PanelController::class,'index'])->name('panel');

    //full calendar
    Route::get('/eventsnav', [EventController::class, 'indexNav']);

    //rutas principales
    Route::resources([
        'users' => UserController::class,
        'roles' => RoleController::class,
        'events'=> EventController::class,
        'years'=> YearController::class,
        'semesters' => SemesterController::class
    ]);
    
    Route::post('/semesters/storeOrUpdate/{year}', [SemesterController::class, 'storeOrUpdate'])->name('semesters.storeOrUpdate');
    Route::get('/semesters/create/{id}', [SemesterController::class, 'create'])->name('semesters.create');
    Route::get('/trash/deleted', [UserController::class, 'seeDeleted'])->name('trash.deleted');
    Route::patch('/trash/restore/{id}', [UserController::class, 'restore'])->name('trash.restore');

    //rutas de tablas
    Route::get('api/dbusers', [UserController::class, 'datatables']);
    Route::get('api/dbroles', [RoleController::class, 'datatables']);
    Route::get('api/dbyears', [YearController::class, 'datatables']);
    
    //rutas del backup
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::post('/backups/download', [BackupController::class, 'download'])->name('backups.download');
});