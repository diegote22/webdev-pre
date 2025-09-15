<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <!-- Header -->
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Mensajes</h1>
                        <p class="text-base-content/70 mt-2">Comunicación con instructores y administradores</p>
                    </div>
                    <div class="stats stats-horizontal shadow">
                        <div class="stat">
                            <div class="stat-title">Sin leer</div>
                            <div class="stat-value text-primary">{{ $messages->where('read', false)->count() }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total</div>
                            <div class="stat-value text-secondary">{{ $messages->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Filtros y Búsqueda -->
            <div class="card bg-base-100 shadow-lg mb-8">
                <div class="card-body">
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                        <div class="flex flex-wrap gap-2">
                            <input type="text" placeholder="Buscar mensajes..."
                                class="input input-bordered w-full max-w-xs" />
                            <button class="btn btn-primary">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-outline">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Filtrar
                                </div>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><a>Todos los mensajes</a></li>
                                    <li><a>Sin leer</a></li>
                                    <li><a>Importantes</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-success">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Nuevo Mensaje
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if ($messages->count() > 0)
                <!-- Lista de Mensajes -->
                <div class="space-y-4">
                    @foreach ($messages as $message)
                        <div
                            class="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow cursor-pointer {{ !$message->read ? 'border-l-4 border-primary' : '' }}">
                            <div class="card-body">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <!-- Avatar -->
                                        <div class="avatar">
                                            <div
                                                class="w-12 h-12 rounded-full bg-gradient-to-r from-primary to-secondary text-white flex items-center justify-center">
                                                <span
                                                    class="text-sm font-bold">{{ substr($message->from, 0, 1) }}</span>
                                            </div>
                                        </div>

                                        <!-- Contenido del Mensaje -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h3
                                                    class="font-semibold text-base-content {{ !$message->read ? 'font-bold' : '' }}">
                                                    {{ $message->from }}
                                                </h3>
                                                @if (!$message->read)
                                                    <div class="badge badge-primary badge-sm">Nuevo</div>
                                                @endif
                                                <span class="text-sm text-base-content/60">
                                                    {{ $message->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <h4
                                                class="text-lg font-medium mb-2 {{ !$message->read ? 'font-semibold' : '' }}">
                                                {{ $message->subject }}
                                            </h4>

                                            <p class="text-base-content/80 {{ !$message->read ? 'font-medium' : '' }}">
                                                {{ $message->preview }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="flex items-center space-x-2">
                                        @if (!$message->read)
                                            <div class="w-3 h-3 bg-primary rounded-full"></div>
                                        @endif

                                        <div class="dropdown dropdown-end">
                                            <div tabindex="0" role="button" class="btn btn-ghost btn-sm btn-square">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </div>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                @if (!$message->read)
                                                    <li><a>Marcar como leído</a></li>
                                                @else
                                                    <li><a>Marcar como no leído</a></li>
                                                @endif
                                                <li><a>Responder</a></li>
                                                <li><a>Archivar</a></li>
                                                <li><a class="text-error">Eliminar</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview expandible -->
                                <div class="collapse collapse-arrow mt-4" id="message-{{ $message->id }}">
                                    <input type="checkbox" />
                                    <div class="collapse-title text-sm font-medium">
                                        Ver mensaje completo
                                    </div>
                                    <div class="collapse-content">
                                        <div class="divider"></div>
                                        <div class="bg-base-200 p-4 rounded-lg">
                                            <p class="text-base-content leading-relaxed">
                                                @if ($message->id == 1)
                                                    ¡Hola {{ $user->name }}!<br><br>
                                                    Te doy la bienvenida al curso de Laravel. Aquí tienes los recursos
                                                    iniciales para comenzar:<br><br>
                                                    • Material de lectura complementario<br>
                                                    • Videos introductorios<br>
                                                    • Ejercicios prácticos<br><br>
                                                    Si tienes alguna pregunta, no dudes en contactarme.<br><br>
                                                    ¡Éxitos en tu aprendizaje!<br>
                                                    Prof. María González
                                                @elseif($message->id == 2)
                                                    Hola,<br><br>
                                                    Hay una nueva tarea disponible en el módulo 3 de tu curso. La fecha
                                                    límite de entrega es el viernes 20 de septiembre.<br><br>
                                                    Instrucciones:<br>
                                                    • Completa los ejercicios del capítulo 5<br>
                                                    • Sube tu solución en formato PDF<br>
                                                    • Incluye capturas de pantalla del resultado<br><br>
                                                    Saludos,<br>
                                                    Ana Paula De la Torre García
                                                @else
                                                    Estimado estudiante,<br><br>
                                                    Hemos actualizado la plataforma con nuevas funcionalidades que
                                                    mejorarán tu experiencia de aprendizaje:<br><br>
                                                    ✨ Nuevo dashboard personalizado<br>
                                                    📊 Métricas de progreso mejoradas<br>
                                                    💬 Sistema de mensajería actualizado<br>
                                                    🎨 Nueva interfaz de usuario<br><br>
                                                    Gracias por ser parte de nuestra comunidad.<br><br>
                                                    Equipo WebDev
                                                @endif
                                            </p>

                                            <div class="divider"></div>

                                            <div class="flex gap-2">
                                                <button class="btn btn-primary btn-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414L2.586 8l3.707-3.707a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Responder
                                                </button>
                                                <button class="btn btn-ghost btn-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                                    </svg>
                                                    Compartir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="flex justify-center mt-8">
                    <div class="join">
                        <button class="join-item btn">«</button>
                        <button class="join-item btn btn-active">1</button>
                        <button class="join-item btn">2</button>
                        <button class="join-item btn">»</button>
                    </div>
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-base-content/30 mb-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-base-content mb-4">No tienes mensajes</h3>
                        <p class="text-base-content/70 mb-8 max-w-md mx-auto">
                            Cuando recibas mensajes de instructores o del sistema, aparecerán aquí.
                        </p>
                        <button class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Enviar Mensaje
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal para Nuevo Mensaje -->
        <input type="checkbox" id="new-message-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-2xl">
                <h3 class="font-bold text-lg mb-4">Nuevo Mensaje</h3>
                <form class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Para</span>
                        </label>
                        <select class="select select-bordered w-full">
                            <option disabled selected>Seleccionar destinatario</option>
                            <option>Prof. María González - Laravel</option>
                            <option>Ana Paula De la Torre García - React</option>
                            <option>Administración - WebDev</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Asunto</span>
                        </label>
                        <input type="text" placeholder="Asunto del mensaje" class="input input-bordered w-full" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Mensaje</span>
                        </label>
                        <textarea class="textarea textarea-bordered h-32" placeholder="Escribe tu mensaje aquí..."></textarea>
                    </div>
                </form>

                <div class="modal-action">
                    <label for="new-message-modal" class="btn">Cancelar</label>
                    <button class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Activar modal de nuevo mensaje
        document.querySelector('.btn-success').addEventListener('click', function() {
            document.getElementById('new-message-modal').checked = true;
        });
    </script>
</x-app-layout>
