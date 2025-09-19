<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Registro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Slabo+27px&family=PT+Sans:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Configuración de tipografías */
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Logo/Marca principal con Slabo 27px */
        .logo-font {
            font-family: 'Slabo 27px', serif;
        }

        /* Títulos y subtítulos con PT Sans */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .heading-font {
            font-family: 'PT Sans', sans-serif;
        }

        /* Textos generales con Roboto */
        p,
        span,
        div,
        a,
        button,
        .text-font {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">

        <!-- Left Panel - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center bg-no-repeat relative"
            style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80');">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>

            <!-- Content over image -->
            <div class="relative z-10 flex flex-col justify-center items-start p-12 text-white max-w-lg">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold mb-4 leading-tight heading-font">Comienza tu viaje de aprendizaje hoy
                    </h1>
                    <p class="text-xl text-white/90 leading-relaxed text-font">Únete a miles de estudiantes que ya están
                        transformando su futuro con nuestra plataforma educativa.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-lg">Registro gratuito</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-lg">Acceso inmediato a cursos</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-lg">Soporte personalizado</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">

                <!-- Logo and Header -->
                <div class="text-center">
                    <div class="mb-6">
                        <a href="/" class="inline-block">
                            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.84L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.84l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2 heading-font">Crea tu cuenta</h2>
                    <p class="text-gray-600 text-font">Completa el formulario para comenzar</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Role Selection -->
                    <div class="form-control">
                        <label class="label" for="role">
                            <span class="label-text font-medium text-gray-700">Registrarme como</span>
                        </label>
                        <select id="role" name="role"
                            class="select select-bordered w-full bg-gray-50 text-gray-700">
                            <option value="Estudiante"
                                {{ old('role', 'Estudiante') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="Profesor" {{ old('role') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                    </div>

                    <!-- Professor Token (hidden unless Profesor) -->
                    <div id="professor-token-field" class="form-control" style="display: none;">
                        <label class="label" for="professor_token">
                            <span class="label-text font-medium text-gray-700">Token de registro (solo
                                Profesores)</span>
                        </label>
                        <input type="text" id="professor_token" name="professor_token"
                            value="{{ old('professor_token') }}"
                            placeholder="Ingresa el token proporcionado por el Administrador"
                            class="input input-bordered w-full focus:input-primary @error('professor_token') input-error @enderror text-gray-700 bg-gray-50" />
                        @error('professor_token')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="form-control">
                        <label class="label" for="name">
                            <span class="label-text font-medium text-gray-700">Nombre Completo</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus autocomplete="name" placeholder="Tu nombre completo"
                            class="input input-bordered w-full focus:input-primary @error('name') input-error @enderror text-gray-700 bg-gray-50" />
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text font-medium text-gray-700">Email</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="tu@email.com"
                            class="input input-bordered w-full focus:input-primary @error('email') input-error @enderror text-gray-700 bg-gray-50" />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-control">
                        <label class="label" for="password">
                            <span class="label-text font-medium text-gray-700">Contraseña</span>
                        </label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            placeholder="contraseña"
                            class="input input-bordered w-full focus:input-primary @error('password') input-error @enderror text-gray-700 bg-gray-50" />
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control">
                        <label class="label" for="password_confirmation">
                            <span class="label-text font-medium text-gray-700">Confirmar contraseña</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            autocomplete="new-password" placeholder="confirmar contraseña"
                            class="input input-bordered w-full focus:input-primary @error('password_confirmation') input-error @enderror text-gray-700 bg-gray-50" />
                        @error('password_confirmation')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Register Button -->
                    <button type="submit"
                        class="btn btn-primary w-full text-white font-semibold py-3 text-base bg-gray-800 hover:bg-gray-900 border-none">
                        Crear Cuenta
                    </button>

                    <!-- Social Login -->
                    <div class="divider text-gray-400">o</div>

                    <button type="button" class="btn btn-outline w-full">
                        <svg class="w-5 h-5 text-red-500 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Login con Google
                    </button>

                    <!-- Login Link -->
                    <div class="text-center pt-4">
                        <p class="text-gray-600">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}"
                                class="text-indigo-600 font-semibold hover:text-indigo-800">
                                Login
                            </a>
                        </p>
                    </div>
                </form>
                <script>
                    (function() {
                        const role = document.getElementById('role');
                        const tokenField = document.getElementById('professor-token-field');
                        const setVisibility = () => {
                            if (role.value === 'Profesor') {
                                tokenField.style.display = '';
                            } else {
                                tokenField.style.display = 'none';
                            }
                        };
                        role.addEventListener('change', setVisibility);
                        // Inicialización por si viene con old('role')
                        setVisibility();
                    })();
                </script>
            </div>
        </div>
    </div>
</body>

</html>
