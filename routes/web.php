<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $secundariaCourses = App\Models\Course::whereHas('category', function ($query) {
        $query->where('name', 'LIKE', '%Secundaria%');
    })->with(['category', 'subCategory', 'professor'])->limit(4)->get();

    $preUniversitarioCourses = App\Models\Course::whereHas('category', function ($query) {
        $query->where('name', 'LIKE', '%Pre-Universitario%');
    })->with(['category', 'subCategory', 'professor'])->limit(4)->get();

    $universitarioCourses = App\Models\Course::whereHas('category', function ($query) {
        $query->where('name', 'LIKE', '%Universitario%');
    })->with(['category', 'subCategory', 'professor'])->limit(4)->get();

    return view('welcome', compact('secundariaCourses', 'preUniversitarioCourses', 'universitarioCourses'));
});


// Dashboard que redirige según el rol del usuario
Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user && $user->role && $user->role->name === 'Profesor') {
        return redirect()->route('courses.index');
    }

    // Para estudiantes y usuarios sin rol específico
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Ruta de perfil que redirige según el rol del usuario
    Route::get('/profile', function () {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user && $user->role && $user->role->name === 'Estudiante') {
            return redirect()->route('student.profile');
        }

        // Para profesores y otros roles
        return app(ProfileController::class)->edit(request());
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del Dashboard del Estudiante
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\Student\DashboardController::class, 'profile'])->name('profile');
        Route::patch('/profile', [App\Http\Controllers\Student\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/profile/password', [App\Http\Controllers\Student\DashboardController::class, 'updatePassword'])->name('profile.password');
        Route::patch('/profile/email', [App\Http\Controllers\Student\DashboardController::class, 'updateEmail'])->name('profile.email');
        Route::post('/profile/avatar', [App\Http\Controllers\Student\DashboardController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::delete('/profile/avatar', [App\Http\Controllers\Student\DashboardController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::get('/my-courses', [App\Http\Controllers\Student\DashboardController::class, 'myCourses'])->name('my-courses');
        Route::get('/messages', [App\Http\Controllers\Student\DashboardController::class, 'messages'])->name('messages');
    });

    // Gestión de cursos para el rol Profesor
    Route::middleware('role:Profesor')->prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
        // Wizard de edición por pasos (UI con aside) para un curso específico
        Route::get('/{course}/wizard', [CourseController::class, 'wizard'])->name('wizard');

        // Guardado de datos generales desde wizard
        Route::post('/{course}/general', [CourseController::class, 'saveGeneral'])->name('general.save');

        // Persistencia por pestaña
        Route::post('/{course}/customize', [CourseController::class, 'saveCustomize'])->name('customize.save');
        Route::post('/{course}/promo', [CourseController::class, 'savePromo'])->name('promo.save');
        Route::post('/{course}/goals', [CourseController::class, 'storeGoal'])->name('goals.store');
        Route::put('/{course}/goals/{goal}', [CourseController::class, 'updateGoal'])->name('goals.update');
        Route::delete('/{course}/goals/{goal}', [CourseController::class, 'destroyGoal'])->name('goals.destroy');
        Route::put('/{course}/goals-reorder', [CourseController::class, 'reorderGoals'])->name('goals.reorder');
        Route::post('/{course}/requirements', [CourseController::class, 'storeRequirement'])->name('requirements.store');
        Route::put('/{course}/requirements/{requirement}', [CourseController::class, 'updateRequirement'])->name('requirements.update');
        Route::delete('/{course}/requirements/{requirement}', [CourseController::class, 'destroyRequirement'])->name('requirements.destroy');
        Route::put('/{course}/requirements-reorder', [CourseController::class, 'reorderRequirements'])->name('requirements.reorder');
        Route::post('/{course}/sections', [CourseController::class, 'storeSection'])->name('sections.store');
        Route::put('/{course}/sections/{section}', [CourseController::class, 'updateSection'])->name('sections.update');
        Route::delete('/{course}/sections/{section}', [CourseController::class, 'destroySection'])->name('sections.destroy');
        Route::post('/{course}/sections/{section}/lessons', [CourseController::class, 'storeLesson'])->name('lessons.store');
        Route::put('/{course}/sections/{section}/lessons/{lesson}', [CourseController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('/{course}/sections/{section}/lessons/{lesson}', [CourseController::class, 'destroyLesson'])->name('lessons.destroy');
        // Materiales de lección (PDFs, imágenes)
        Route::post('/{course}/sections/{section}/lessons/{lesson}/attachments', [CourseController::class, 'storeLessonAttachment'])->name('lessons.attachments.store');
        Route::delete('/{course}/sections/{section}/lessons/{lesson}/attachments/{attachment}', [CourseController::class, 'destroyLessonAttachment'])->name('lessons.attachments.destroy');
    });

    // Rutas de Instructor (flujo simplificado de edición/creación)
    Route::middleware('role:Profesor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::resource('courses', InstructorCourseController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    });
});

// Rutas públicas para ver cursos por categoría
Route::get('/cursos/secundaria', [CourseController::class, 'secundaria'])->name('courses.secundaria');
Route::get('/cursos/pre-universitario', [CourseController::class, 'preUniversitario'])->name('courses.pre-universitario');
Route::get('/cursos/universitario', [CourseController::class, 'universitario'])->name('courses.universitario');

// Búsqueda pública de cursos
Route::get('/buscar', [CourseController::class, 'search'])->name('courses.search');

// Ruta pública para ver el detalle de un curso
Route::get('/curso/{course}', [CourseController::class, 'show'])->name('courses.show');

// Nota: El grupo de rutas de admin con DashboardController fue removido temporalmente
// porque el controlador no existe en este repositorio. Puedes restaurarlo cuando
// agregues App\Http\Controllers\Admin\DashboardController y sus vistas.

require __DIR__ . '/auth.php';
