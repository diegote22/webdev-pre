<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6">Notificaciones</h1>
        <p class="mb-4 text-base-content/70">Listado simulado de notificaciones (próximo a conectar con backend real).
        </p>
        @php
            $messages = [
                (object) [
                    'id' => 1,
                    'from' => 'Sistema',
                    'subject' => 'Actualización de plataforma',
                    'preview' => 'Se han aplicado mejoras de rendimiento',
                    'created_at' => now()->subHours(3),
                    'read' => false,
                ],
                (object) [
                    'id' => 2,
                    'from' => 'Moderación',
                    'subject' => 'Nuevo curso enviado',
                    'preview' => 'El curso "Inglés Básico" espera revisión',
                    'created_at' => now()->subDay(),
                    'read' => false,
                ],
            ];
        @endphp
        <div class="space-y-3">
            @forelse($messages as $m)
                <div class="p-4 rounded-lg border bg-base-100 flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold">{{ $m->subject }}</h2>
                        <span class="text-xs opacity-60">{{ $m->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-primary">De: {{ $m->from }}</p>
                    <p class="text-sm text-base-content/70">{{ $m->preview }}</p>
                </div>
            @empty
                <div class="p-4 border rounded-lg bg-base-100">Sin notificaciones.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
