<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-light-gray">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-transparent">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

    @include('layouts.footer')

    @if(session('success'))
            <div id="globalSuccessModal" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-primary/80 rounded-lg shadow p-6 w-full max-w-md text-center">
                    <h3 class="text-lg font-semibold mb-2">Acción realizada</h3>
                    <p class="text-light-gray mb-4">{{ session('success') }}</p>
                    <button onclick="document.getElementById('globalSuccessModal').remove()" class="px-4 py-2 bg-accent-blue text-white rounded">Cerrar</button>
                </div>
            </div>
        @endif

        <div id="confirmModal" class="hidden fixed inset-0 items-center justify-center bg-black/50 z-50">
            <div class="bg-primary/80 rounded-lg shadow p-6 w-full max-w-md text-center">
                <h3 class="text-lg font-semibold mb-2">Confirmar acción</h3>
                <p id="confirmMessage" class="text-light-gray mb-4">¿Seguro que deseas continuar?</p>
                <div class="flex justify-center gap-3">
                    <button id="confirmCancel" class="px-4 py-2 border rounded">Cancelar</button>
                    <button id="confirmOk" class="px-4 py-2 bg-red-600 text-white rounded">Sí, continuar</button>
                </div>
            </div>
        </div>

        <script>
            // Interceptar botones con data-confirm y formularios con data-confirm
            (function(){
                const modal = document.getElementById('confirmModal');
                const msg = document.getElementById('confirmMessage');
                const btnOk = document.getElementById('confirmOk');
                const btnCancel = document.getElementById('confirmCancel');
                let pendingAction = null;
                function openConfirm(message, onOk){
                    msg.textContent = message || '¿Seguro que deseas continuar?';
                    pendingAction = onOk;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
                function closeConfirm(){
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    pendingAction = null;
                }
                btnCancel.addEventListener('click', closeConfirm);
                btnOk.addEventListener('click', ()=>{ if(pendingAction) pendingAction(); closeConfirm(); });

                document.addEventListener('click', (e)=>{
                    const target = e.target.closest('[data-confirm]');
                    if(!target) return;
                    const message = target.getAttribute('data-confirm') || '¿Seguro?';
                    e.preventDefault();
                    openConfirm(message, ()=>{
                        if(target.tagName === 'A') {
                            window.location.href = target.getAttribute('href');
                        } else if(target.closest('form')) {
                            target.closest('form').submit();
                        }
                    });
                });

                document.addEventListener('submit', (e)=>{
                    const form = e.target;
                    if(form.matches('[data-confirm]')){
                        const message = form.getAttribute('data-confirm') || '¿Seguro?';
                        e.preventDefault();
                        openConfirm(message, ()=> form.submit());
                    }
                });
            })();
        </script>
    </body>
</html>
