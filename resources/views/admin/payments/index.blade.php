@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 flex items-center gap-4">Pagos
            <a href="{{ route('admin.payments.export', request()->query()) }}" class="btn btn-sm">Exportar CSV</a>
        </h1>
        <div class="stats shadow mb-6">
            <div class="stat">
                <div class="stat-title">Total Aprobado</div>
                <div class="stat-value text-success">{{ number_format($totalApproved, 2) }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Mes Actual</div>
                <div class="stat-value">{{ number_format($monthApproved, 2) }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Últimos 30 días</div>
                <div class="stat-value">{{ number_format($last30, 2) }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Promedio Diario (30d)</div>
                <div class="stat-value">{{ number_format($dailyAvg30, 2) }}</div>
            </div>
        </div>
        <form method="GET" class="flex flex-wrap gap-2 mb-4 items-end">
            <div>
                <label class="block text-sm">Buscar</label>
                <input type="text" name="q" value="{{ $q }}" class="input input-bordered input-sm"
                    placeholder="Curso, email, ref" />
            </div>
            <div>
                <label class="block text-sm">Estado</label>
                <select name="status" class="select select-bordered select-sm">
                    <option value="">-- Todos --</option>
                    @foreach (['initiated', 'approved', 'pending', 'in_process', 'rejected', 'cancelled', 'refunded', 'charged_back'] as $st)
                        <option value="{{ $st }}" @selected($status === $st)>{{ $st }}
                            ({{ $statusCounts[$st] ?? 0 }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button class="btn btn-sm btn-primary">Filtrar</button>
                <a href="{{ route('admin.payments') }}" class="btn btn-sm">Reset</a>
            </div>
        </form>
        <div class="overflow-x-auto bg-base-100 rounded shadow">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Curso</th>
                        <th>Usuario</th>
                        <th>Monto</th>
                        <th>Moneda</th>
                        <th>Estado</th>
                        <th>Método</th>
                        <th>Referencia</th>
                        <th>Enrolado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td><a class="link link-primary"
                                    href="{{ route('admin.payments.show', $p) }}">{{ $p->id }}</a></td>
                            <td>{{ $p->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="max-w-[180px] truncate" title="{{ $p->course?->title }}">
                                {{ $p->course?->title ?? '—' }}</td>
                            <td>{{ $p->user?->email ?? '—' }}</td>
                            <td>{{ number_format($p->transaction_amount ?? 0, 2) }}</td>
                            <td>{{ $p->currency_id }}</td>
                            <td>
                                <span
                                    class="badge {{ $p->status === 'approved' ? 'badge-success' : ($p->status === 'rejected' ? 'badge-error' : 'badge-ghost') }}">{{ $p->status }}</span>
                            </td>
                            <td>{{ $p->payment_method_id }}</td>
                            <td class="text-xs">{{ $p->external_reference }}</td>
                            <td>{!! $p->enrolled_at ? '<span class="badge badge-success">Sí</span>' : '—' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-6">Sin pagos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $payments->links() }}</div>
    </div>
@endsection
