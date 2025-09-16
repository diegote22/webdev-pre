<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Comparte el conteo de mensajes no leídos con todas las vistas (simulado)
        View::composer('*', function ($view) {
            $unread = 0;
            if (Auth::check()) {
                // Intentar usar la nueva clave global; si no existe, caer a la anterior y migrarla
                $unread = Session::get('unread_messages');
                if ($unread === null) {
                    $legacy = Session::get('student.unread_messages');
                    if ($legacy !== null) {
                        $unread = $legacy;
                        Session::put('unread_messages', $unread);
                        Session::forget('student.unread_messages');
                    }
                }

                if ($unread === null) {
                    // Simulación inicial de mensajes (compartida para cualquier rol)
                    $messages = collect([
                        (object) [
                            'id' => 1,
                            'from' => 'Prof. María González',
                            'subject' => 'Bienvenido al curso de Laravel',
                            'preview' => 'Hola! Te doy la bienvenida al curso. Aquí tienes los recursos...',
                            'created_at' => now()->subHours(2),
                            'read' => false,
                            'avatar' => null,
                        ],
                        (object) [
                            'id' => 2,
                            'from' => 'Ana Paula De la Torre García',
                            'subject' => 'Tarea disponible',
                            'preview' => 'Hay una nueva tarea disponible en el módulo 3...',
                            'created_at' => now()->subHours(5),
                            'read' => true,
                            'avatar' => null,
                        ],
                        (object) [
                            'id' => 3,
                            'from' => 'WebDev Administrador',
                            'subject' => 'Actualización del sistema',
                            'preview' => 'Hemos actualizado la plataforma con nuevas funcionalidades...',
                            'created_at' => now()->subDay(),
                            'read' => false,
                            'avatar' => null,
                        ],
                    ]);
                    $unread = $messages->where('read', false)->count();
                    Session::put('unread_messages', $unread);
                }
            }
            $view->with('unreadMessagesCount', (int) ($unread ?? 0));
        });
    }
}
