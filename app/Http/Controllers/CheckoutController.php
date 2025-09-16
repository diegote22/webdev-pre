<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function pay(Course $course, MercadoPagoService $mp): RedirectResponse
    {
        // Validar que el curso esté publicado y que no esté ya inscrito
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($course->students()->where('users.id', $user->id)->exists()) {
            return redirect()->route('student.courses.player', $course)->with('status', 'Ya estás inscrito.');
        }

        if ($course->price <= 0) {
            // Inscripción directa gratuita
            DB::table('enrollments')->insertOrIgnore([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect()->route('student.courses.player', $course)->with('status', 'Inscripción gratuita realizada.');
        }

        $preference = $mp->createCoursePreference([
            'id' => $course->id,
            'title' => $course->title,
            'price' => $course->price,
        ], [
            'back_urls' => [
                'success' => route('checkout.success', $course),
                'failure' => route('checkout.failure', $course),
                'pending' => route('checkout.pending', $course),
            ],
            'auto_return' => 'approved',
        ]);

        return redirect($preference->init_point);
    }

    public function success(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            DB::table('enrollments')->insertOrIgnore([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('student.courses.player', $course)->with('status', 'Pago aprobado y curso habilitado.');
    }

    public function pending(Request $request, Course $course): RedirectResponse
    {
        return redirect()->route('courses.show', $course)->with('status', 'Pago pendiente.');
    }

    public function failure(Request $request, Course $course): RedirectResponse
    {
        return redirect()->route('courses.show', $course)->with('error', 'El pago no se completó.');
    }
}
