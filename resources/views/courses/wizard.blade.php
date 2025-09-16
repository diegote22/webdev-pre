<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Curso • Asistente') }} — <span class="font-normal">{{ $course->title }}</span>
        </h2>
    </x-slot>

    <div class="py-6" x-data="{
        step: '{{ request('tab', session('activeTab', 'general')) }}',
        order: { general: 1, customize: 2, promo: 3, goals: 4, requirements: 5, sections: 6 },
        stepsArr: ['general', 'customize', 'promo', 'goals', 'requirements', 'sections']
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Steps responsive arriba -->
            <div class="mb-6">
                <ul class="steps steps-vertical lg:steps-horizontal w-full">
                    <li class="step cursor-pointer" @click="step='general'"
                        :class="order[step] >= 1 ? 'step-primary' : ''">Datos generales</li>
                    <li class="step cursor-pointer" @click="step='customize'"
                        :class="order[step] >= 2 ? 'step-primary' : ''">Personalizar</li>
                    <li class="step cursor-pointer" @click="step='promo'"
                        :class="order[step] >= 3 ? 'step-primary' : ''">Video promo</li>
                    <li class="step cursor-pointer" @click="step='goals'"
                        :class="order[step] >= 4 ? 'step-primary' : ''">Metas</li>
                    <li class="step cursor-pointer" @click="step='requirements'"
                        :class="order[step] >= 5 ? 'step-primary' : ''">Requisitos</li>
                    <li class="step cursor-pointer" @click="step='sections'"
                        :class="order[step] >= 6 ? 'step-primary' : ''">Secciones</li>
                </ul>
            </div>

            <!-- Panel de contenido: muestra una sola sección por vez -->
            <section class="">
                <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-base-content">
                        {{-- Mensajes de estado se muestran mediante toast global en el layout --}}
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

            <!-- Barra pegajosa de navegación -->
            <div class="fixed bottom-6 right-6 z-40">
                <div class="btn-group shadow-xl">
                    <button class="btn" @click="step = stepsArr[Math.max(order[step]-2, 0)]"
                        :disabled="order[step] === 1">Anterior</button>
                    <button class="btn btn-primary" @click="step = stepsArr[Math.min(order[step], stepsArr.length-1)]"
                        :disabled="order[step] === stepsArr.length">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
