@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <!-- Navigation Breadcrumb -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Preguntas Frecuentes</span>
            </div>
        </div>
    </nav>

    <!-- Hero Section con imagen de fondo -->
    <section class="relative h-96 md:h-[500px] bg-cover bg-center bg-no-repeat w-full"
        style="background-image: url('{{ asset('img/fondo-webdev-1.png') }}');">
        <!-- Overlay tenue para la imagen de fondo -->
        <div class="absolute inset-0 bg-white bg-opacity-60"></div>

        <!-- Contenido del Hero -->
        <div class="relative w-full h-full px-6 py-8 md:py-12 flex items-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight heading-font">
                        Preguntas <span class="text-blue-600 logo-font">Frecuentes</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 text-font">
                        Encuentra respuestas a las dudas más comunes sobre nuestros cursos, métodos de pago,
                        certificaciones
                        y todo lo que necesitas saber para comenzar tu aprendizaje.
                    </p>
                    <div class="mt-8 flex justify-center md:justify-start gap-4">
                        <a href="#preguntas"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-300 shadow-lg text-font">Ver
                            Preguntas</a>
                        <a href="#contacto"
                            class="px-8 py-3 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300 shadow-lg text-font">Contactar
                            Soporte</a>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg h-64 md:h-96 flex items-center justify-center">
                    @php
                        $preguntasVideoPath = @file_exists(storage_path('app/preguntas_video.txt'))
                            ? trim(file_get_contents(storage_path('app/preguntas_video.txt')))
                            : null;
                        $preguntasImagePath = @file_exists(storage_path('app/preguntas_image.txt'))
                            ? trim(file_get_contents(storage_path('app/preguntas_image.txt')))
                            : null;
                    @endphp
                    @if ($preguntasVideoPath && Storage::disk('public')->exists($preguntasVideoPath))
                        <video class="w-full h-full object-cover rounded-lg shadow-md" autoplay loop muted playsinline
                            poster="{{ $preguntasImagePath && Storage::disk('public')->exists($preguntasImagePath) ? Storage::url($preguntasImagePath) : '' }}">
                            <source src="{{ Storage::url($preguntasVideoPath) }}" type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    @elseif ($preguntasImagePath && Storage::disk('public')->exists($preguntasImagePath))
                        <img src="{{ Storage::url($preguntasImagePath) }}" alt="Preguntas Frecuentes"
                            class="w-full h-full object-cover rounded-lg shadow-md">
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <div class="text-white text-center p-6">
                                <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h3 class="text-2xl font-bold heading-font">¿Tienes dudas?</h3>
                                <p class="text-blue-100 text-font">Video próximamente</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Preguntas Frecuentes -->
    <section id="preguntas" class="container mx-auto px-6 py-16 md:py-24">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 heading-font">Preguntas Frecuentes</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                Aquí encontrarás las respuestas a las preguntas más comunes sobre nuestros cursos y servicios.
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Pregunta 1 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq1')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Cómo puedo inscribirme en un curso?
                        </h3>
                        <svg id="faq1-icon" class="w-6 h-6 text-blue-600 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq1" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        Para inscribirte en un curso, simplemente navega por nuestro catálogo, selecciona el curso de tu
                        interés,
                        haz clic en "Ver Curso Completo" y luego en "Inscribirse". Podrás completar el proceso de pago
                        de forma segura
                        y comenzar de inmediato.
                    </p>
                </div>
            </div>

            <!-- Pregunta 2 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq2')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Qué métodos de pago aceptan?</h3>
                        <svg id="faq2-icon" class="w-6 h-6 text-blue-600 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq2" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        Aceptamos múltiples métodos de pago para tu comodidad: tarjetas de crédito y débito (Visa,
                        MasterCard, American Express),
                        transferencias bancarias, y pagos a través de MercadoPago. Todos los pagos son procesados de
                        forma segura.
                    </p>
                </div>
            </div>

            <!-- Pregunta 3 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq3')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Los cursos tienen certificación?</h3>
                        <svg id="faq3-icon" class="w-6 h-6 text-blue-600 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq3" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        Sí, todos nuestros cursos incluyen un certificado de finalización digital. Para obtenerlo, debes
                        completar
                        todas las lecciones y aprobar las evaluaciones correspondientes. El certificado incluye tu
                        nombre,
                        el nombre del curso y la fecha de finalización.
                    </p>
                </div>
            </div>

            <!-- Pregunta 4 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq4')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Puedo acceder a los cursos desde mi
                            móvil?</h3>
                        <svg id="faq4-icon" class="w-6 h-6 text-blue-600 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq4" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        ¡Por supuesto! Nuestra plataforma está completamente optimizada para dispositivos móviles.
                        Puedes acceder
                        a todos tus cursos desde tu smartphone o tablet, estudiar offline descargando el contenido,
                        y sincronizar tu progreso en todos tus dispositivos.
                    </p>
                </div>
            </div>

            <!-- Pregunta 5 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq5')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Hay descuentos disponibles?</h3>
                        <svg id="faq5-icon" class="w-6 h-6 text-blue-600 transform transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq5" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        Sí, ofrecemos descuentos especiales en varias ocasiones: descuentos por volumen al inscribirse
                        en múltiples cursos,
                        promociones estacionales, descuentos para estudiantes, y ofertas especiales para nuevos
                        usuarios.
                        Suscríbete a nuestro newsletter para no perderte ninguna promoción.
                    </p>
                </div>
            </div>

            <!-- Pregunta 6 -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-6 cursor-pointer" onclick="toggleFaq('faq6')">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 heading-font">¿Cuánto tiempo tengo para completar un
                            curso?</h3>
                        <svg id="faq6-icon" class="w-6 h-6 text-blue-600 transform transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div id="faq6" class="hidden px-6 pb-6">
                    <p class="text-gray-600 text-font">
                        Una vez que te inscribes en un curso, tienes acceso ilimitado de por vida. No hay límites de
                        tiempo
                        para completarlo, puedes estudiar a tu propio ritmo. Además, tendrás acceso a todas las
                        actualizaciones
                        futuras del curso sin costo adicional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto -->
    <section id="contacto" class="bg-gray-50 py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 heading-font">¿Aún tienes dudas?</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                    Nuestro equipo de soporte está aquí para ayudarte. Contáctanos y te responderemos lo antes posible.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <!-- Email -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Email</h4>
                    <p class="text-gray-600 text-font">soporte@webdev-pre.com</p>
                    <p class="text-sm text-gray-500 text-font mt-2">Respuesta en 24 horas</p>
                </div>

                <!-- Chat -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Chat en Vivo</h4>
                    <p class="text-gray-600 text-font">Disponible las 24/7</p>
                    <button
                        class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 text-font">
                        Iniciar Chat
                    </button>
                </div>

                <!-- Teléfono -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Teléfono</h4>
                    <p class="text-gray-600 text-font">+54 11 1234-5678</p>
                    <p class="text-sm text-gray-500 text-font mt-2">Lun-Vie 9:00-18:00</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleFaq(faqId) {
            const faqContent = document.getElementById(faqId);
            const faqIcon = document.getElementById(faqId + '-icon');

            if (faqContent.classList.contains('hidden')) {
                faqContent.classList.remove('hidden');
                faqIcon.classList.add('rotate-180');
            } else {
                faqContent.classList.add('hidden');
                faqIcon.classList.remove('rotate-180');
            }
        }
    </script>
</x-app-layout>
