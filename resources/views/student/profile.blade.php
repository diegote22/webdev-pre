@php
    use Illuminate\Support\Facades\Storage;
    // Fallback por si la vista se renderiza sin pasar $user explícitamente
    $user = $user ?? \Illuminate\Support\Facades\Auth::user();
@endphp

<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <!-- Header -->
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Editar Perfil</h1>
                        <p class="text-base-content/70 mt-2">Gestiona tu información personal y configuración de cuenta
                        </p>
                    </div>
                    <!-- Navigation Links -->
                    <div class="flex gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 15v-1a2 2 0 114 0v1" />
                            </svg>
                            Mi Panel
                        </a>
                        <a href="{{ route('student.profile') }}" class="btn btn-primary btn-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Perfil
                        </a>
                        <a href="{{ route('student.my-courses') }}" class="btn btn-outline btn-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Mis Cursos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Información Personal -->
            <div class="card bg-base-100 shadow-xl mb-8">
                <div class="card-body">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-2">Información Personal</h2>
                        <p class="text-base-content/70">Actualiza tu información personal y biografía</p>
                    </div>

                    <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Información Básica -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Nombre *</span>
                                </label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', explode(' ', $user->name)[0] ?? '') }}"
                                    class="input input-bordered focus:input-primary" placeholder="Ej: Diego Carlos"
                                    required />
                                @error('first_name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Apellidos *</span>
                                </label>
                                <input type="text" name="last_name"
                                    value="{{ old('last_name', implode(' ', array_slice(explode(' ', $user->name), 1)) ?: '') }}"
                                    class="input input-bordered focus:input-primary" placeholder="Ej: González"
                                    required />
                                @error('last_name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Correo Electrónico *</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="input input-bordered focus:input-primary" placeholder="Ej: tuEmail@ejemplo.com"
                                required />
                            @error('email')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Avatar -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Foto de Perfil</span>
                                <span class="label-text-alt text-sm">Formatos: JPG, PNG (máx. 2MB)</span>
                            </label>
                            <input type="file" name="avatar"
                                class="file-input file-input-bordered focus:file-input-primary"
                                accept="image/jpeg,image/jpg,image/png" />
                            @if ($user->avatar_path)
                                <div class="mt-2 flex items-center gap-4">
                                    <div class="avatar">
                                        <div class="w-16 h-16 rounded-full">
                                            <img src="{{ $user->avatar_url }}" alt="Avatar actual" />
                                        </div>
                                    </div>
                                    <span class="text-sm text-base-content/70">Foto actual</span>
                                </div>
                            @endif
                            @error('avatar')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Biografía -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Sobre Mí</span>
                                <span class="label-text-alt text-sm">(Opcional)</span>
                            </label>
                            <textarea name="biography" class="textarea textarea-bordered h-32 focus:textarea-primary resize-none"
                                placeholder="Cuéntanos un poco sobre ti, tus intereses, experiencia o lo que te motiva a estudiar...">{{ old('biography', $user->biography ?? '') }}</textarea>
                            @error('biography')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-4">
                            <button type="button" class="btn btn-outline" onclick="window.location.reload()">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-2">Cambiar Contraseña</h2>
                        <p class="text-base-content/70">Actualiza tu contraseña de acceso</p>
                    </div>

                    <form method="POST" action="{{ route('student.profile.password') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Contraseña Actual *</span>
                            </label>
                            <input type="password" name="current_password"
                                class="input input-bordered focus:input-primary" required />
                            @error('current_password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Nueva Contraseña *</span>
                            </label>
                            <input type="password" name="password" class="input input-bordered focus:input-primary"
                                required />
                            @error('password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Confirmar Nueva Contraseña *</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                class="input input-bordered focus:input-primary" required />
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" class="btn btn-outline" onclick="this.closest('form').reset()">
                                Limpiar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
