<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YearController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\UserAnswerController;

Route::group(['middleware' => ['role:Administrador|Profesor']], function () {

    // Panel de administración
    Route::get('/panel', [PanelController::class,'index'])->name('panel');

    // Full calendar
    Route::get('/eventsnav', [EventController::class, 'indexNav']);

    // Rutas principales
    Route::resources([
        'users' => UserController::class,
        'roles' => RoleController::class,
        'events' => EventController::class,
        'years' => YearController::class,
        'semesters' => SemesterController::class,
        'topics' => TopicController::class,
        'contents' => ContentController::class,
        'activities' => ActivityController::class,
        'exams' => ExamController::class,
        'options' => OptionController::class,
        'user-answers' => UserAnswerController::class
    ]);

    // Rutas específicas con exclusiones
    Route::resource('questions', QuestionController::class)->except(['create', 'store']);
    Route::resource('contents', ContentController::class)->except(['create']);
    Route::resource('semesters', SemesterController::class)->except(['create']);

    //question 
    Route::get('questions/create/{exam_id}', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store/{exam}', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('questions/edit/{exam}', [QuestionController::class, 'edit'])->name('questions.edit');

    //contents
    Route::get('contents/create/{topic_id}', [ContentController::class, 'create'])->name('contents.create');

    //semestre
    Route::post('/semesters/storeOrUpdate/{year}', [SemesterController::class, 'storeOrUpdate'])->name('semesters.storeOrUpdate');
    Route::get('/semesters/create/{id}', [SemesterController::class, 'create'])->name('semesters.create');

    Route::get('topics/{topicId}/contents', [ContentController::class, 'index'])->name('topics.contents.index');
    Route::get('/trash/deleted', [UserController::class, 'seeDeleted'])->name('trash.deleted');
    Route::patch('/trash/restore/{id}', [UserController::class, 'restore'])->name('trash.restore');
    Route::get('api/years/{year}/semesters', [TopicController::class, 'getSemestersByYear']);

    // Rutas de tablas
    Route::get('api/dbusers', [UserController::class, 'datatables']);
    Route::get('api/dbroles', [RoleController::class, 'datatables']);
    Route::get('api/dbyears', [YearController::class, 'datatables']);
    Route::get('api/dbtopics', [TopicController::class, 'datatables']);
    Route::get('api/dbactivities', [ActivityController::class, 'datatables']);
    Route::get('api/dbcontents/{id}', [ContentController::class, 'datatables'])->name('contents.datatables');
    Route::get('api/dbexams', [ExamController::class, 'datatables'])->name('admin.exams.datatables');

    // Rutas del backup
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::post('/backups/download', [BackupController::class, 'download'])->name('backups.download');

    // Rutas de vistas y likes
    Route::post('/topics/{topic}/view', [TopicController::class, 'storeView'])->name('topics.view');
    Route::post('/topics/{topic}/like', [TopicController::class, 'storeLike'])->name('topics.like');
});






