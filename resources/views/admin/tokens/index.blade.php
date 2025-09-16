<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Tokens de Invitación para Profesores</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Volver</a>
        </div>

        {{-- Mensajes de éxito se muestran vía toast global en layouts/app.blade.php --}}

        <form method="POST" action="{{ route('admin.tokens.create') }}" class="card bg-base-100 shadow p-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label"><span class="label-text">Nota</span></label>
                    <input name="note" type="text" class="input input-bordered w-full"
                        placeholder="Opcional (para quién es)" />
                </div>
                <div>
                    <label class="label"><span class="label-text">Expira el</span></label>
                    <input name="expires_at" type="datetime-local" class="input input-bordered w-full" />
                </div>
                <div class="flex items-end">
                    <button class="btn btn-primary w-full">Generar Token</button>
                </div>
            </div>
        </form>

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Listado</h2>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Creado</th>
                                <th>Expira</th>
                                <th>Usado por</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tokens as $t)
                                <tr>
                                    <td class="font-mono">{{ $t->token }}</td>
                                    <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $t->expires_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td>{{ $t->used_by ? $t->used_by . ' @ ' . $t->used_at?->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-outline btn-error"
                                            onclick="openRevokeModal('{{ $t->id }}', '{{ $t->token }}')">Revocar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $tokens->links() }}</div>
            </div>
        </div>

        <!-- Modal de confirmación de revocación -->
        <dialog id="revokeModal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Revocar token</h3>
                <p class="py-2 text-base-content/70">¿Estás seguro de que deseas revocar este token?</p>
                <p class="py-1"><span class="font-mono text-sm bg-base-200 px-2 py-1 rounded"
                        id="revokeTokenText"></span></p>
                <div class="modal-action">
                    <form id="revokeForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-error">Revocar</button>
                    </form>
                    <form method="dialog">
                        <button class="btn">Cancelar</button>
                    </form>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>

    <script>
        function openRevokeModal(id, token) {
            const modal = document.getElementById('revokeModal');
            const form = document.getElementById('revokeForm');
            const span = document.getElementById('revokeTokenText');
            span.textContent = token;
            form.action = `{{ url('admin/tokens') }}/${id}`;
            modal.showModal();
        }
    </script>
</x-app-layout>
