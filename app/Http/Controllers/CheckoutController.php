<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Payment;
use MercadoPago\Client\Payment\PaymentClient;

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

        $base = rtrim(config('mercadopago.base_url'), '/');
        try {
            $preference = $mp->createCoursePreference([
                'id' => $course->id,
                'title' => $course->title,
                'price' => $course->price,
            ], [
                'back_urls' => [
                    'success' => $base . route('checkout.success', $course, absolute: false),
                    'failure' => $base . route('checkout.failure', $course, absolute: false),
                    'pending' => $base . route('checkout.pending', $course, absolute: false),
                ],
                'auto_return' => 'approved',
            ]);
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('courses.show', $course)->with('error', 'No se pudo iniciar el pago. Intenta nuevamente en unos minutos.');
        }

        return redirect($preference->init_point);
    }

    public function success(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();
        $paymentId = $request->query('payment_id');
        $status = null;
        if ($paymentId) {
            try {
                $client = new PaymentClient();
                $remote = $client->get((int)$paymentId);
                if ($remote) {
                    $status = $remote->status;
                    $payment = Payment::firstOrCreate([
                        'mp_payment_id' => $remote->id,
                    ], [
                        'user_id' => $user?->id,
                        'course_id' => $course->id,
                        'preference_id' => $remote->order['id'] ?? '',
                        'external_reference' => $remote->external_reference,
                        'status' => $remote->status,
                        'status_detail' => $remote->status_detail,
                        'transaction_amount' => $remote->transaction_amount,
                        'net_amount' => $remote->net_amount,
                        'currency_id' => $remote->currency_id,
                        'payment_method_id' => $remote->payment_method_id,
                        'payment_type_id' => $remote->payment_type_id,
                        'payer_email' => $remote->payer['email'] ?? null,
                        'payer_id' => $remote->payer['id'] ?? null,
                        'processed_at' => now(),
                    ]);
                    if ($user && $payment->status === 'approved') {
                        DB::table('enrollments')->insertOrIgnore([
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        if (!$payment->enrolled_at) {
                            $payment->enrolled_at = now();
                            $payment->save();
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignorar, el webhook cubrirá actualización
            }
        }

        if ($user && DB::table('enrollments')->where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.courses.player', $course)->with('status', 'Acceso al curso habilitado.');
        }

        return redirect()->route('courses.show', $course)->with('status', $status === 'pending' ? 'Pago pendiente de confirmación.' : 'Procesando tu pago, recibirás acceso al aprobarse.');
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
