<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Curso • Asistente') }} — <span class="font-normal">{{ $course->title }}</span>
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ step: '{{ request('tab', session('activeTab', 'general')) }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabs superiores (móvil/tablet) -->
            <div class="md:hidden mb-4">
                <div class="tabs tabs-boxed w-full">
                    <button @click="step='general'" :class="step==='general' ? 'tab tab-active' : 'tab'">General</button>
                    <button @click="step='customize'" :class="step==='customize' ? 'tab tab-active' : 'tab'">Personalizar</button>
                    <button @click="step='promo'" :class="step==='promo' ? 'tab tab-active' : 'tab'">Promo</button>
                    <button @click="step='goals'" :class="step==='goals' ? 'tab tab-active' : 'tab'">Metas</button>
                    <button @click="step='requirements'" :class="step==='requirements' ? 'tab tab-active' : 'tab'">Requisitos</button>
                    <button @click="step='sections'" :class="step==='sections' ? 'tab tab-active' : 'tab'">Secciones</button>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- Aside de pestañas verticales -->
                <aside class="col-span-12 lg:col-span-3 hidden md:block">
                    <nav class="sticky top-4">
                        <div class="tabs tabs-lifted tabs-vertical w-full">
                            <button @click="step='general'" :class="step==='general' ? 'tab tab-active' : 'tab'">Datos generales</button>
                            <button @click="step='customize'" :class="step==='customize' ? 'tab tab-active' : 'tab'">Personalizar curso</button>
                            <button @click="step='promo'" :class="step==='promo' ? 'tab tab-active' : 'tab'">Video promocional</button>
                            <div class="mt-2 px-3 text-xs text-gray-500">Contenido</div>
                            <button @click="step='goals'" :class="step==='goals' ? 'tab tab-active' : 'tab'">Metas del curso</button>
                            <button @click="step='requirements'" :class="step==='requirements' ? 'tab tab-active' : 'tab'">Requisitos del curso</button>
                            <button @click="step='sections'" :class="step==='sections' ? 'tab tab-active' : 'tab'">Secciones del curso</button>
                        </div>
                    </nav>
                </aside>

                <!-- Panel de contenido: muestra una sola sección por vez -->
                <section class="col-span-12 lg:col-span-9">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            @if (session('status'))
                                <div class="alert alert-success mb-4">
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
