@extends('layouts.mobirise')

@section('content')
    <!-- Hero estilo "Tu Futuro Médico" -->
    <section class="relative overflow-hidden">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                    Tu Futuro Médico
                </h1>
                <p class="mt-5 text-lg text-gray-600">
                    Prepara tu ingreso a ciencias de la salud con los mejores cursos online.
                </p>
                <div class="mt-8 flex items-center gap-3">
                    <a href="#"
                        class="px-6 py-3 rounded-full bg-purple-700 text-white font-semibold hover:bg-purple-800">Comienza</a>
                    <a href="#contacto"
                        class="px-6 py-3 rounded-full bg-white text-gray-900 font-semibold border border-gray-200 hover:bg-gray-100">Enviar
                        Mensaje</a>
                </div>
            </div>
            <div class="relative">
                <div
                    class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-purple-100 via-fuchsia-100 to-pink-100 border border-purple-200">
                </div>
            </div>
        </div>
    </section>

    <!-- Bloque de features simple para evidenciar layout -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-900">Mentores Expertos</h3>
                <p class="mt-2 text-gray-600">Aprende con profesionales de la salud y prepara tu ingreso con confianza.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-900">Rutas de Estudio</h3>
                <p class="mt-2 text-gray-600">Contenidos curados que cubren las principales materias de ingreso.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-900">Listo para Móvil</h3>
                <p class="mt-2 text-gray-600">Estudia donde quieras con una experiencia moderna y accesible.</p>
            </div>
        </div>
    </section>
@endsection
