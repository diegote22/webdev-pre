<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Curso • Asistente') }} — <span class="font-normal">{{ $course->title }}</span>
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ step: '{{ request('tab', session('activeTab', 'general')) }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6">
                <!-- Aside de pestañas verticales -->
                <aside class="col-span-12 lg:col-span-3">
                    <nav class="bg-white shadow-sm rounded-lg p-2 sticky top-4">
                        <ul class="space-y-1">
                            <li>
                                <button @click="step='general'"
                                    :class="step === 'general' ? 'bg-indigo-50 text-indigo-700' : 'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Datos generales</button>
                            </li>
                            <li>
                                <button @click="step='customize'"
                                    :class="step === 'customize' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Personalizar curso</button>
                            </li>
                            <li>
                                <button @click="step='promo'"
                                    :class="step === 'promo' ? 'bg-indigo-50 text-indigo-700' : 'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Video promocional</button>
                            </li>
                            <li>
                                <button @click="step='goals'"
                                    :class="step === 'goals' ? 'bg-indigo-50 text-indigo-700' : 'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Metas del curso</button>
                            </li>
                            <li>
                                <button @click="step='requirements'"
                                    :class="step === 'requirements' ? 'bg-indigo-50 text-indigo-700' :
                                        'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Requisitos del curso</button>
                            </li>
                            <li>
                                <button @click="step='sections'"
                                    :class="step === 'sections' ? 'bg-indigo-50 text-indigo-700' : 'text-black hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2 rounded">Secciones del curso</button>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <!-- Panel de contenido: muestra una sola sección por vez -->
                <section class="col-span-12 lg:col-span-9">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            @if (session('status'))
                                <div class="mb-4 px-4 py-2 rounded bg-green-50 text-green-700 border border-green-200">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div x-show="step==='general'">
                                @include('courses.partials.general')
                            </div>
                            <div x-show="step==='customize'" x-cloak>
                                @include('courses.partials.customize')
                            </div>
                            <div x-show="step==='promo'" x-cloak>
                                @include('courses.partials.promo')
                            </div>
                            <div x-show="step==='goals'" x-cloak>
                                @include('courses.partials.goals')
                            </div>
                            <div x-show="step==='requirements'" x-cloak>
                                @include('courses.partials.requirements')
                            </div>
                            <div x-show="step==='sections'" x-cloak>
                                @include('courses.partials.sections')
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
