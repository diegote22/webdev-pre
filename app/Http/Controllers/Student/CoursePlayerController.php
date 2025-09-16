<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CoursePlayerController extends Controller
{
    protected function ensureEnrollment(Course $course): void
    {
        $user = Auth::user();
        if (!$user) abort(403);
        if (!$course->students()->where('users.id', $user->id)->exists()) {
            abort(403, 'No estás inscrito en este curso.');
        }
    }

    public function index(Course $course): RedirectResponse
    {
        $this->ensureEnrollment($course);
        $firstLesson = $course->sections()->with('lessons')->get()
            ->flatMap->lessons
            ->sortBy('position')
            ->first();
        if (!$firstLesson) {
            return back()->with('error', 'El curso aún no tiene contenido.');
        }
        return redirect()->route('student.courses.lesson', [$course, $firstLesson]);
    }

    public function showLesson(Course $course, Lesson $lesson): View
    {
        $this->ensureEnrollment($course);
        if ($lesson->section->course_id !== $course->id) abort(404);

        $course->load([
            'sections.lessons.attachments' => function ($q) {
                $q->orderBy('position');
            },
        ]);

        $progress = DB::table('lesson_progress')
            ->where('user_id', Auth::id())
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('student.courses.player', [
            'course' => $course,
            'lesson' => $lesson,
            'progress' => $progress,
        ]);
    }

    public function saveProgress(Request $request, Course $course, Lesson $lesson): JsonResponse
    {
        $this->ensureEnrollment($course);
        if ($lesson->section->course_id !== $course->id) abort(404);

        $data = $request->validate([
            'seconds' => ['required', 'integer', 'min:0', 'max:86400'],
            'completed' => ['nullable', 'boolean'],
        ]);

        DB::table('lesson_progress')->updateOrInsert(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'seconds' => $data['seconds'],
                'completed_at' => ($data['completed'] ?? false) ? now() : DB::raw('completed_at'),
                'updated_at' => now(),
                'created_at' => DB::raw('COALESCE(created_at, NOW())'),
            ]
        );

        return response()->json(['ok' => true]);
    }
}
