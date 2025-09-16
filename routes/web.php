<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Admin\AdminController as AdminAreaController;
use Illuminate\Support\Facades\Route;
use App\Models\Course as CourseModel;

Route::get('/', function () {
    $secundariaCourses = CourseModel::published()->whereHas('category', function ($query) {
        $query->where('slug', 'secundaria');
    })->with(['category', 'subCategory', 'professor'])->latest('id')->limit(4)->get();

    $preUniversitarioCourses = CourseModel::published()->whereHas('category', function ($query) {
        $query->where('slug', 'pre-universitario');
    })->with(['category', 'subCategory', 'professor'])->latest('id')->limit(4)->get();

    $universitarioCourses = CourseModel::published()->whereHas('category', function ($query) {
        $query->where('slug', 'universitario');
    })->with(['category', 'subCategory', 'professor'])->latest('id')->limit(4)->get();

    return view('welcome', compact('secundariaCourses', 'preUniversitarioCourses', 'universitarioCourses'));
})->name('home');


// Dashboard que muestra un panel según el rol del usuario
Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user && $user->role) {
        $r = trim($user->role->name);
        if (strcasecmp($r, 'Profesor') === 0 || strcasecmp($r, 'Docente') === 0) {
            // Mostrar panel del profesor
            return app(\App\Http\Controllers\Professor\DashboardController::class)->index(request());
        }
    }

    if ($user && $user->role && strcasecmp(trim($user->role->name), 'Administrador') === 0) {
        return redirect()->route('admin.dashboard');
    }

    // Para estudiantes y usuarios sin rol específico
    return redirect()->route('student.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Notificaciones genéricas (admin y otros roles) - simulado
    Route::get('/notifications', function () {
        // Resetear contador global (simulación de haberlas leído)
        session(['unread_messages' => 0]);
        return view('notifications.index');
    })->name('notifications.index');

    // Nueva ruta de perfil que redirige según el rol del usuario
    Route::get('/perfil', function () {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user && $user->role && $user->role->name === 'Estudiante') {
            return redirect()->route('student.profile');
        }

        if ($user && $user->role && (strcasecmp(trim($user->role->name), 'Profesor') === 0 || strcasecmp(trim($user->role->name), 'Docente') === 0)) {
            return redirect()->route('professor.profile');
        }

        // Para otros roles (admin, etc.)
        return app(ProfileController::class)->edit(request());
    })->name('profile.edit');

    // Rutas del Dashboard del Estudiante (requiere email verificado)
    Route::prefix('student')->name('student.')->middleware('verified')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\Student\DashboardController::class, 'profile'])->name('profile');
        Route::patch('/profile', [App\Http\Controllers\Student\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/profile/password', [App\Http\Controllers\Student\DashboardController::class, 'updatePassword'])->name('profile.password');
        Route::patch('/profile/email', [App\Http\Controllers\Student\DashboardController::class, 'updateEmail'])->name('profile.email');
        Route::post('/profile/avatar', [App\Http\Controllers\Student\DashboardController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::delete('/profile/avatar', [App\Http\Controllers\Student\DashboardController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::get('/my-courses', [App\Http\Controllers\Student\DashboardController::class, 'myCourses'])->name('my-courses');
        Route::get('/messages', [App\Http\Controllers\Student\DashboardController::class, 'messages'])->name('messages');
        // Player de cursos comprados
        Route::get('/courses/{course}/player', [App\Http\Controllers\Student\CoursePlayerController::class, 'index'])->name('courses.player');
        Route::get('/courses/{course}/lesson/{lesson}', [App\Http\Controllers\Student\CoursePlayerController::class, 'showLesson'])->name('courses.lesson');
        Route::post('/courses/{course}/lesson/{lesson}/progress', [App\Http\Controllers\Student\CoursePlayerController::class, 'saveProgress'])->name('courses.lesson.progress');
    });

    // Dashboard propio del profesor (opcional acceso directo)
    Route::middleware('role:Profesor,Docente')->get('/professor/dashboard', [\App\Http\Controllers\Professor\DashboardController::class, 'index'])->name('professor.dashboard');

    // Rutas del perfil del profesor
    Route::middleware('role:Profesor,Docente')->prefix('professor')->name('professor.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Professor\DashboardController::class, 'profile'])->name('profile');
        Route::patch('/profile', [\App\Http\Controllers\Professor\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/profile/password', [\App\Http\Controllers\Professor\DashboardController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/avatar', [\App\Http\Controllers\Professor\DashboardController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::delete('/profile/avatar', [\App\Http\Controllers\Professor\DashboardController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    });

    // Gestión de cursos para el rol Profesor/Docente
    Route::middleware('role:Profesor,Docente')->prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
        Route::put('/{course}/publish', [CourseController::class, 'publish'])->name('publish');
        Route::put('/{course}/unpublish', [CourseController::class, 'unpublish'])->name('unpublish');
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
    Route::middleware('role:Profesor,Docente')->prefix('instructor')->name('instructor.')->group(function () {
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

// Reseñas de cursos (requiere login, además verificamos inscripción)
Route::post('/curso/{course}/review', [CourseController::class, 'storeReview'])->middleware(['auth'])->name('courses.review');

// Nota: El grupo de rutas de admin con DashboardController fue removido temporalmente
// porque el controlador no existe en este repositorio. Puedes restaurarlo cuando
// agregues App\Http\Controllers\Admin\DashboardController y sus vistas.

require __DIR__ . '/auth.php';

// Rutas de Administración (solo Administrador)
Route::middleware(['auth', 'verified', 'role:Administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminAreaController::class, 'dashboard'])->name('dashboard');
    Route::get('/branding', [AdminAreaController::class, 'branding'])->name('branding');
    Route::post('/branding', [AdminAreaController::class, 'saveBranding'])->name('branding.save');
    // Foto de administrador
    Route::post('/avatar', [AdminAreaController::class, 'uploadAvatar'])->name('avatar.upload');
    Route::delete('/avatar', [AdminAreaController::class, 'deleteAvatar'])->name('avatar.delete');

    // Gestión de tokens de invitación para profesores
    Route::get('/tokens', [AdminAreaController::class, 'tokens'])->name('tokens');
    Route::post('/tokens', [AdminAreaController::class, 'createToken'])->name('tokens.create');
    Route::delete('/tokens/{token}', [AdminAreaController::class, 'revokeToken'])->name('tokens.revoke');

    // Revisión de contenidos (cursos)
    Route::get('/courses', [AdminAreaController::class, 'courses'])->name('courses');
    Route::post('/courses/{course}/publish', [AdminAreaController::class, 'publishCourse'])->name('courses.publish');
    Route::post('/courses/{course}/unpublish', [AdminAreaController::class, 'unpublishCourse'])->name('courses.unpublish');
    Route::post('/courses/{course}/under-review', [AdminAreaController::class, 'markUnderReview'])->name('courses.underReview');
    Route::post('/courses/{course}/reject', [AdminAreaController::class, 'rejectCourse'])->name('courses.reject');

    // Alumnos
    Route::get('/students', [AdminAreaController::class, 'students'])->name('students');

    // Gestión de grilla de portada
    Route::get('/home-grid', [AdminAreaController::class, 'homeGrid'])->name('homeGrid');
    Route::post('/home-grid', [AdminAreaController::class, 'storeHomeGrid'])->name('homeGrid.store');
    Route::delete('/home-grid/{item}', [AdminAreaController::class, 'deleteHomeGridItem'])->name('homeGrid.delete');

    // Marquee (temas desplazables)
    Route::get('/marquee', [AdminAreaController::class, 'marquee'])->name('marquee');
    Route::post('/marquee', [AdminAreaController::class, 'storeMarquee'])->name('marquee.store');
    Route::delete('/marquee/{item}', [AdminAreaController::class, 'deleteMarquee'])->name('marquee.delete');
    Route::post('/marquee/{item}/toggle', [AdminAreaController::class, 'toggleMarquee'])->name('marquee.toggle');
});
