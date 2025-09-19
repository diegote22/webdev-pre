@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto p-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Pago #{{ $payment->id }}</h1>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.payments.reconcile', $payment) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline">Reconciliar</button>
                </form>
                <a href="{{ route('admin.payments') }}" class="btn btn-sm">Volver</a>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="card bg-base-100 shadow p-4">
                <h2 class="font-semibold mb-2">Resumen</h2>
                <ul class="text-sm space-y-1">
                    <li><strong>Estado:</strong> <span
                            class="badge {{ $payment->status === 'approved' ? 'badge-success' : ($payment->status === 'rejected' ? 'badge-error' : '') }}">{{ $payment->status }}</span>
                    </li>
                    <li><strong>Monto:</strong> {{ number_format($payment->transaction_amount, 2) }}
                        {{ $payment->currency_id }}</li>
                    <li><strong>Método:</strong> {{ $payment->payment_method_id }} ({{ $payment->payment_type_id }})</li>
                    <li><strong>Usuario:</strong> {{ $payment->user?->email ?? '—' }}</li>
                    <li><strong>Curso:</strong> {{ $payment->course?->title ?? '—' }}</li>
                    <li><strong>Referencia:</strong> {{ $payment->external_reference }}</li>
                    <li><strong>Preference ID:</strong> {{ $payment->preference_id }}</li>
                    <li><strong>MP Payment ID:</strong> {{ $payment->mp_payment_id }}</li>
                    <li><strong>Enrolado:</strong>
                        {{ $payment->enrolled_at ? $payment->enrolled_at->format('Y-m-d H:i') : 'No' }}</li>
                    <li><strong>Creado:</strong> {{ $payment->created_at }}</li>
                    <li><strong>Actualizado:</strong> {{ $payment->updated_at }}</li>
                </ul>
            </div>
            <div class="card bg-base-100 shadow p-4">
                <h2 class="font-semibold mb-2">Payload (raw)</h2>
                <pre class="text-xs overflow-auto max-h-96">{{ json_encode($payment->raw_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
    </div>
@endsection
