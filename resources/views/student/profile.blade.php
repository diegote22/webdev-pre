@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <!-- Header -->
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-3xl font-bold text-base-content">Editar Perfil</h1>
                <p class="text-base-content/70 mt-2">Gestiona tu información personal y configuración de cuenta</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Alertas de notificación -->
            @if (session('success'))
                <div class="alert alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="tabs tabs-boxed bg-base-100 shadow-lg mb-8 p-2">
                <a class="tab tab-active" onclick="showTab('profile', this)">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    Perfil
                </a>
                <a class="tab" onclick="showTab('photo', this)">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                            clip-rule="evenodd" />
                    </svg>
                    Fotografía
                </a>
                <a class="tab" onclick="showTab('security', this)">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Seguridad
                </a>
                <a class="tab" onclick="showTab('privacy', this)">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Privacidad
                </a>
            </div>

            <!-- Tab Content: Perfil -->
            <div id="profile-tab" class="tab-content">
                <div class="max-w-4xl mx-auto">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold mb-2">Perfil Público</h2>
                                <p class="text-base-content/70">Añade información sobre ti</p>
                            </div>

                            <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-8"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <!-- Información Básica -->
                                <div class="form-section bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold mb-6 flex items-center text-gray-800">
                                        <div
                                            class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">
                                            1</div>
                                        Información básica
                                    </h3>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">Nombre *</span>
                                            </label>
                                            <input type="text" name="first_name"
                                                value="{{ old('first_name', explode(' ', $user->name)[0] ?? '') }}"
                                                class="input input-bordered focus:input-primary h-12"
                                                placeholder="Diego Carlos" required />
                                            @error('first_name')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">Apellidos *</span>
                                            </label>
                                            <input type="text" name="last_name"
                                                value="{{ old('last_name', implode(' ', array_slice(explode(' ', $user->name), 1)) ?: '') }}"
                                                class="input input-bordered focus:input-primary h-12"
                                                placeholder="González" required />
                                            @error('last_name')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-control mt-6">
                                        <label class="label">
                                            <span class="label-text font-semibold text-gray-700">Tienes algún título o
                                                curso/os realizado</span>
                                            <span class="label-text-alt text-sm text-gray-500">(máx. 60
                                                caracteres)</span>
                                        </label>
                                        <input type="text" name="title"
                                            value="{{ old('title', $user->title ?? '') }}"
                                            class="input input-bordered focus:input-primary h-12"
                                            placeholder="Ej: Técnico en Informática, Curso de JavaScript, Diseño Gráfico"
                                            maxlength="60" />
                                        <label class="label">
                                            <span class="label-text-alt text-xs text-gray-500">Menciona tus títulos
                                                académicos, cursos completados o certificaciones</span>
                                        </label>
                                        @error('title')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <!-- Biografía -->
                                <div class="form-section bg-blue-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold mb-6 flex items-center text-gray-800">
                                        <div
                                            class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">
                                            2</div>
                                        Biografía
                                    </h3>

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        <div class="lg:col-span-2">
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold text-gray-700">Cuéntanos
                                                        sobre ti</span>
                                                </label>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <button type="button" class="btn btn-sm btn-outline btn-primary"
                                                        onclick="formatText('bold')" title="Texto en negrita">
                                                        <strong>B</strong>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline btn-primary"
                                                        onclick="formatText('italic')" title="Texto en cursiva">
                                                        <em>I</em>
                                                    </button>
                                                </div>
                                                <textarea name="biography" id="biography" class="textarea textarea-bordered h-40 focus:textarea-primary resize-none"
                                                    placeholder="Describe tu experiencia profesional, habilidades y lo que te apasiona...">{{ old('biography', $user->biography ?? '') }}</textarea>
                                                <label class="label">
                                                    <span class="label-text-alt text-xs text-gray-500">
                                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        No se permiten enlaces promocionales o de cupones
                                                    </span>
                                                </label>
                                                @error('biography')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="lg:col-span-1">
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold text-gray-700">Idioma
                                                        principal</span>
                                                </label>
                                                <select name="language"
                                                    class="select select-bordered focus:select-primary h-12">
                                                    <option value="es"
                                                        {{ old('language', $user->language ?? 'es') == 'es' ? 'selected' : '' }}>
                                                        🇪🇸 Español</option>
                                                    <option value="en"
                                                        {{ old('language', $user->language ?? '') == 'en' ? 'selected' : '' }}>
                                                        🇺🇸 English</option>
                                                    <option value="pt"
                                                        {{ old('language', $user->language ?? '') == 'pt' ? 'selected' : '' }}>
                                                        🇧🇷 Português</option>
                                                    <option value="fr"
                                                        {{ old('language', $user->language ?? '') == 'fr' ? 'selected' : '' }}>
                                                        🇫🇷 Français</option>
                                                </select>
                                                @error('language')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <!-- Enlaces -->
                                <div class="form-section bg-green-50 rounded-lg p-6">
                                    <h3 class="text-xl font-semibold mb-6 flex items-center text-gray-800">
                                        <div
                                            class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">
                                            3</div>
                                        Enlaces y redes sociales
                                    </h3>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Website -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">🌐 Página
                                                    web</span>
                                            </label>
                                            <input type="url" name="website"
                                                value="{{ old('website', $user->website ?? '') }}"
                                                class="input input-bordered focus:input-primary h-12"
                                                placeholder="https://tu-sitio-web.com" />
                                            @error('website')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- Facebook -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">📘 Facebook</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-blue-600 text-white text-sm">facebook.com/</span>
                                                <input type="text" name="facebook"
                                                    value="{{ old('facebook', $user->facebook ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="tu.usuario" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Solo tu nombre de
                                                    usuario</span>
                                            </label>
                                            @error('facebook')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- Instagram -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">📷
                                                    Instagram</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-pink-600 text-white text-sm">instagram.com/</span>
                                                <input type="text" name="instagram"
                                                    value="{{ old('instagram', $user->instagram ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="tu.usuario" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Solo tu nombre de
                                                    usuario</span>
                                            </label>
                                            @error('instagram')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- LinkedIn -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">💼 LinkedIn</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-blue-700 text-white text-sm">linkedin.com/</span>
                                                <input type="text" name="linkedin"
                                                    value="{{ old('linkedin', $user->linkedin ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="in/tu-perfil" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Ej: in/juan-perez,
                                                    company/empresa</span>
                                            </label>
                                            @error('linkedin')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- TikTok -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">🎵 TikTok</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-black text-white text-sm">tiktok.com/</span>
                                                <input type="text" name="tiktok"
                                                    value="{{ old('tiktok', $user->tiktok ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="@tu.usuario" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Incluye el @ en tu
                                                    usuario</span>
                                            </label>
                                            @error('tiktok')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- X (Twitter) -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">🐦 X
                                                    (Twitter)</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-black text-white text-sm">x.com/</span>
                                                <input type="text" name="twitter"
                                                    value="{{ old('twitter', $user->twitter ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="tu_usuario" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Solo tu nombre de
                                                    usuario</span>
                                            </label>
                                            @error('twitter')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>

                                        <!-- YouTube -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-700">🎥 YouTube</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-red-600 text-white text-sm">youtube.com/</span>
                                                <input type="text" name="youtube"
                                                    value="{{ old('youtube', $user->youtube ?? '') }}"
                                                    class="input input-bordered flex-1 focus:input-primary h-12"
                                                    placeholder="@tu-canal" />
                                            </div>
                                            <label class="label">
                                                <span class="label-text-alt text-xs text-gray-500">Tu nombre de canal o
                                                    usuario</span>
                                            </label>
                                            @error('youtube')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <!-- Información adicional -->
                                <div class="form-section bg-purple-50 rounded-lg p-6">
                                    <div class="alert alert-info border-blue-200 bg-blue-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            class="stroke-current shrink-0 w-6 h-6 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="font-bold text-blue-800">Tu perfil público</h4>
                                            <p class="text-blue-700">Estos enlaces aparecerán en tu perfil y ayudarán a
                                                otros estudiantes e instructores a conectar contigo profesionalmente.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Guardar -->
                                <div class="flex justify-center pt-8 pb-4">
                                    <div class="flex gap-4">
                                        <button type="button" class="btn btn-outline btn-lg px-8"
                                            onclick="window.location.reload()">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            Restaurar
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg px-12 shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Guardar cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Fotografía -->
            <div id="photo-tab" class="tab-content">
                <div class="max-w-3xl mx-auto">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold mb-2">Fotografía</h2>
                                <p class="text-base-content/70">Añade una foto tuya al perfil</p>
                            </div>

                            <!-- Vista previa de imagen -->
                            <div class="text-center mb-8">
                                <p class="text-lg font-semibold mb-6 text-gray-700">Vista previa de la imagen</p>

                                <div
                                    class="inline-block p-8 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mb-6">
                                    @if ($user->avatar_path)
                                        <div class="w-48 h-48 mx-auto rounded-lg overflow-hidden shadow-lg">
                                            <img src="{{ Storage::url($user->avatar_path) }}" alt="Avatar"
                                                class="w-full h-full object-cover" />
                                        </div>
                                    @else
                                        <div
                                            class="w-48 h-48 mx-auto rounded-lg bg-gray-200 flex items-center justify-center">
                                            <div class="text-center text-gray-500">
                                                <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <p class="text-sm">Sin imagen</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Formulario de subida -->
                            <div class="text-center mb-6">
                                <p class="text-gray-600 mb-6">
                                    Añade o cambia la imagen
                                </p>

                                <form method="POST" action="{{ route('student.profile.avatar.upload') }}"
                                    enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <div class="form-control max-w-md mx-auto">
                                        <div class="relative">
                                            <input type="file" name="avatar" id="avatar-input" class="hidden"
                                                accept="image/*" onchange="previewImage(this)" />
                                            <label for="avatar-input"
                                                class="btn btn-primary btn-lg px-8 cursor-pointer">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Subir imagen
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">
                                            No has seleccionado ningún archivo
                                        </p>
                                        @error('avatar')
                                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Botón de guardar (oculto inicialmente) -->
                                    <div id="save-section" class="hidden">
                                        <button type="submit" class="btn btn-success btn-lg px-8">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Guardar cambios
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Botón eliminar -->
                            @if ($user->avatar_path)
                                <div class="text-center">
                                    <form method="POST" action="{{ route('student.profile.avatar.delete') }}"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-error btn-sm"
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar tu foto de perfil?')">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v4a1 1 0 11-2 0V7zM12 7a1 1 0 112 0v4a1 1 0 11-2 0V7z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <!-- Información adicional -->
                            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-semibold mb-1">Recomendaciones:</p>
                                        <ul class="list-disc list-inside space-y-1 text-blue-700">
                                            <li>Formato: JPG, PNG o GIF</li>
                                            <li>Tamaño máximo: 2MB</li>
                                            <li>Recomendado: imagen cuadrada (ej: 400x400px)</li>
                                            <li>Asegúrate de que tu rostro sea claramente visible</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Seguridad -->
            <div id="security-tab" class="tab-content">
                <div class="card bg-base-100 shadow-xl max-w-3xl mx-auto">
                    <div class="card-body">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold">Cuenta</h2>
                            <p class="text-base-content/70">Edita la configuración de tu cuenta y cambia la contraseña
                                aquí.</p>
                        </div>

                        <!-- Email actual + editar -->
                        <div class="mb-6">
                            <form method="POST" action="{{ route('student.profile.email') }}" class="space-y-3"
                                id="email-form">
                                @csrf
                                @method('patch')

                                <label class="label"><span class="label-text font-semibold">Correo
                                        electrónico:</span></label>
                                <div class="join w-full">
                                    <input id="email-input" type="email" name="email"
                                        class="input input-bordered join-item w-full"
                                        value="{{ old('email', $user->email) }}" disabled />
                                    <button type="button" id="email-edit-btn"
                                        class="btn btn-outline btn-primary join-item" onclick="enableEmailEdit()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('email')
                                    <div class="text-error text-sm">{{ $message }}</div>
                                @enderror

                                <div id="email-save-row" class="hidden gap-2">
                                    <button class="btn btn-primary" type="submit">Guardar email</button>
                                    <button type="button" class="btn"
                                        onclick="cancelEmailEdit()">Cancelar</button>
                                </div>
                            </form>
                        </div>

                        <div class="divider"></div>

                        <!-- Cambiar contraseña -->
                        <form method="POST" action="{{ route('student.profile.password') }}"
                            class="space-y-4 max-w-xl">
                            @csrf
                            @method('patch')

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Contraseña actual</span>
                                </label>
                                <input type="password" name="current_password"
                                    class="input input-bordered focus:input-primary" required />
                                @error('current_password')
                                    <div class="text-error text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Nueva contraseña</span>
                                </label>
                                <input type="password" name="password"
                                    class="input input-bordered focus:input-primary" required />
                                @error('password')
                                    <div class="text-error text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Confirmar contraseña</span>
                                </label>
                                <input type="password" name="password_confirmation"
                                    class="input input-bordered focus:input-primary" required />
                            </div>

                            <div class="card-actions">
                                <button type="submit" class="btn btn-primary">Cambiar la contraseña</button>
                            </div>
                        </form>

                        <div class="divider"></div>

                        <!-- Cerrar cuenta -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold">Cerrar cuenta</h3>
                            <p class="text-base-content/70">Cierra tu cuenta de usuario permanentemente.</p>

                            <div class="alert alert-warning bg-warning/10 border-warning/30">
                                <svg class="w-6 h-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <div>
                                    <p class="font-semibold">Advertencia:</p>
                                    <p class="text-sm">Si cierras tu cuenta, perderás el acceso a tus cursos y a los
                                        datos asociados. Esta acción es irreversible incluso si vuelves a registrarte
                                        con el mismo correo.</p>
                                </div>
                            </div>

                            <p class="text-sm text-base-content/70">Ten en cuenta que si quieres revertir esta acción
                                deberás contactar con soporte dentro de los próximos días desde la solicitud.</p>

                            <button class="btn btn-error" type="button"
                                onclick="document.getElementById('closeAccountModal').showModal()">Cerrar
                                cuenta</button>
                        </div>

                        <!-- Modal Cerrar cuenta -->
                        <dialog id="closeAccountModal" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Confirmar cierre de cuenta</h3>
                                <p class="py-2 text-sm text-base-content/70">Para continuar, introduce tu contraseña
                                    actual. Esta acción eliminará tu cuenta de forma permanente.</p>

                                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-3">
                                    @csrf
                                    @method('delete')

                                    <div class="form-control">
                                        <label class="label"><span class="label-text">Contraseña</span></label>
                                        <input type="password" name="password" class="input input-bordered"
                                            placeholder="Tu contraseña actual" required />
                                        @error('password', 'userDeletion')
                                            <div class="text-error text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="modal-action">
                                        <button type="button" class="btn"
                                            onclick="document.getElementById('closeAccountModal').close()">Cancelar</button>
                                        <button type="submit" class="btn btn-error">Cerrar cuenta</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Privacidad -->
            <div id="privacy-tab" class="tab-content">
                <div class="card bg-base-100 shadow-xl max-w-4xl mx-auto">
                    <div class="card-body">
                        <h3 class="card-title mb-6">Configuración de Privacidad</h3>

                        <div class="space-y-6">
                            <div class="alert alert-info">
                                <svg class="w-6 h-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="font-bold">Control de tu información</h4>
                                    <p class="text-sm">Gestiona quién puede ver tu información y actividad</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="p-4 rounded-lg border border-base-300 bg-base-200/30 flex items-center justify-between gap-4">
                                    <div class="pr-2">
                                        <div class="font-semibold">Mostrar tu perfil a los usuarios que han iniciado
                                            sesión</div>
                                        <p class="text-sm text-base-content/60">Tu nombre y foto aparecerán en los
                                            cursos que tomes</p>
                                    </div>
                                    <input type="checkbox" class="toggle toggle-primary" checked />
                                </div>

                                <div
                                    class="p-4 rounded-lg border border-base-300 bg-base-200/30 flex items-center justify-between gap-4">
                                    <div class="pr-2">
                                        <div class="font-semibold">Mostrar los cursos que estás tomando en tu página de
                                            perfil</div>
                                        <p class="text-sm text-base-content/60">Otros pueden ver qué estás estudiando
                                        </p>
                                    </div>
                                    <input type="checkbox" class="toggle toggle-primary" />
                                </div>
                            </div>

                            <div class="divider"></div>

                            <h4 class="text-lg font-semibold">Notificaciones por Email</h4>

                            <div class="grid grid-cols-1 gap-2">
                                <div class="flex items-center justify-between p-2 rounded-md hover:bg-base-200/40">
                                    <span class="label-text">Nuevos mensajes de instructores</span>
                                    <input type="checkbox" class="checkbox checkbox-primary" checked />
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-md hover:bg-base-200/40">
                                    <span class="label-text">Actualizaciones de cursos</span>
                                    <input type="checkbox" class="checkbox checkbox-primary" checked />
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-md hover:bg-base-200/40">
                                    <span class="label-text">Recordatorios de estudio</span>
                                    <input type="checkbox" class="checkbox checkbox-primary" />
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-md hover:bg-base-200/40">
                                    <span class="label-text">Newsletter semanal</span>
                                    <input type="checkbox" class="checkbox checkbox-primary" />
                                </div>
                            </div>

                            <div class="card-actions justify-end">
                                <button class="btn btn-primary">Guardar Preferencias</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName, clickedElement) {
            console.log('Cambiando a pestaña:', tabName); // Debug

            // Ocultar todas las pestañas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
                console.log('Ocultando:', tab.id); // Debug
            });

            // Remover clase activa de todas las pestañas de navegación
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('tab-active');
            });

            // Mostrar la pestaña seleccionada
            const targetTab = document.getElementById(tabName + '-tab');
            console.log('Mostrando pestaña:', targetTab ? targetTab.id : 'No encontrada'); // Debug

            if (targetTab) {
                targetTab.classList.add('active');
                console.log('Pestaña activada:', targetTab.id, 'Clases:', targetTab.classList.toString());
            }

            // Agregar clase activa a la pestaña clickeada
            if (clickedElement) {
                clickedElement.classList.add('tab-active');
            }
        }

        function formatText(command) {
            const textarea = document.getElementById('biography');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);

            if (selectedText) {
                let formattedText;
                if (command === 'bold') {
                    formattedText = `**${selectedText}**`;
                } else if (command === 'italic') {
                    formattedText = `*${selectedText}*`;
                }

                textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
                textarea.focus();
                textarea.setSelectionRange(start + (command === 'bold' ? 2 : 1), start + selectedText.length + (command ===
                    'bold' ? 2 : 1));
            }
        }

        function previewImage(input) {
            const file = input.files[0];
            const previewContainer = document.querySelector('#photo-tab .w-48.h-48');
            const fileText = document.querySelector('#photo-tab .text-xs.text-gray-500');
            const saveSection = document.getElementById('save-section');

            if (file) {
                // Validar tamaño (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. El tamaño máximo es 2MB.');
                    input.value = '';
                    return;
                }

                // Validar tipo de archivo
                if (!file.type.match('image.*')) {
                    alert('Por favor selecciona un archivo de imagen válido.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML =
                        `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg shadow-lg" />`;
                    fileText.textContent = `Archivo seleccionado: ${file.name}`;
                    fileText.classList.remove('text-gray-500');
                    fileText.classList.add('text-green-600');
                    saveSection.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                // Restaurar vista original si no hay archivo
                previewContainer.innerHTML = `
                    <div class="text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm">Sin imagen</p>
                    </div>
                `;
                fileText.textContent = 'No has seleccionado ningún archivo';
                fileText.classList.remove('text-green-600');
                fileText.classList.add('text-gray-500');
                saveSection.classList.add('hidden');
            }
        }

        // Add input group styling for social media inputs
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM cargado, inicializando pestañas...'); // Debug

            // Asegurar que solo la primera pestaña esté activa
            const profileTab = document.getElementById('profile-tab');
            if (profileTab) {
                profileTab.classList.add('active');
                console.log('Pestaña perfil activada'); // Debug
            }

            // Style input groups
            const inputGroups = document.querySelectorAll('.input-group');
            inputGroups.forEach(group => {
                const span = group.querySelector('.input-group-text');
                const input = group.querySelector('input');
                if (span && input) {
                    span.style.borderTopRightRadius = '0';
                    span.style.borderBottomRightRadius = '0';
                    input.style.borderTopLeftRadius = '0';
                    input.style.borderBottomLeftRadius = '0';
                    input.style.borderLeft = 'none';
                }
            });
        });

        // Seguridad: edición de email
        function enableEmailEdit() {
            const input = document.getElementById('email-input');
            const saveRow = document.getElementById('email-save-row');
            const btn = document.getElementById('email-edit-btn');
            if (input && saveRow && btn) {
                input.disabled = false;
                input.focus();
                saveRow.classList.remove('hidden');
                saveRow.classList.add('flex');
                btn.classList.add('btn-disabled');
                btn.disabled = true;
            }
        }

        function cancelEmailEdit() {
            const input = document.getElementById('email-input');
            const saveRow = document.getElementById('email-save-row');
            const btn = document.getElementById('email-edit-btn');
            if (input && saveRow && btn) {
                input.value = input.getAttribute('value');
                input.disabled = true;
                saveRow.classList.add('hidden');
                saveRow.classList.remove('flex');
                btn.classList.remove('btn-disabled');
                btn.disabled = false;
            }
        }
    </script>

    <style>
        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            background-color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem 0 0 0.5rem;
            white-space: nowrap;
        }

        .input-group .input {
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .form-section {
            padding: 0;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Control de pestañas ultra simplificado */
        .tab-content {
            display: none !important;
        }

        .tab-content.active {
            display: block !important;
        }

        /* La visibilidad de pestañas la controla la clase .active */

        /* Mejorar los input groups */
        .input-group-text {
            min-width: 140px;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Hacer que todos los inputs tengan la misma altura */
        .input,
        .select,
        .textarea {
            font-size: 0.95rem;
        }

        /* Espaciado consistente */
        .form-control {
            margin-bottom: 0.5rem;
        }

        /* Mejorar las etiquetas */
        .label-text {
            font-size: 0.9rem;
        }

        /* Grid responsive mejorado */
        @media (max-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .lg\:col-span-2 {
                grid-column: span 1;
            }

            .lg\:col-span-1 {
                grid-column: span 1;
            }
        }
    </style>
</x-app-layout>
