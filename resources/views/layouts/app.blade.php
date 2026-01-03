<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MedicCitas') }} - Sistema de Citas Médicas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tu CSS Custom -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- NAVBAR -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="hero-section">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content con Alertas -->
        <main class="container my-4 fade-in">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-5 py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="container text-center">
                <p class="mb-0">
                    <i class="fas fa-heartbeat"></i> MedicCitas © {{ date('Y') }}
                </p>
                <small class="opacity-75">Cuidando tu salud con tecnología</small>
            </div>
        </footer>

        <!-- ⚡ IMPORTANTE: Bootstrap JS Bundle (Gestionado por Vite/App.js ahora) -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->


        <!-- ✅ WEBSOCKETS: Escuchar notificaciones en tiempo real -->
        @auth
        <script type="module">
            // Esperar a que Echo esté disponible
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.Echo === 'undefined') {
                    console.error('❌ Echo no está cargado. Verifica que hayas ejecutado npm run build');
                    return;
                }

            console.log('✅ Echo está disponible');
            console.log('🔌 Conectando a WebSocket para usuario ID: {{ Auth::id() }}');

            // Escuchar notificaciones en el canal privado del usuario
        window.Echo.private('user.{{ Auth::id() }}')
            .listen('.appointment.notification', (notification) => {
                console.log('✅ Notificación recibida:', notification);
                    
                    // Mostrar notificación del navegador
                    if (Notification.permission === "granted") {
                        new Notification(notification.title, {
                            body: notification.message,
                            icon: '/favicon.ico',
                            badge: '/favicon.ico'
                        });
                    }
                    
                    // Mostrar toast en la página
                    showToast(notification.title, notification.message, 'info');
                    
                    // Reproducir sonido (opcional)
                    playNotificationSound();
                });
                .error((error) => {
                console.error('❌ Error en el canal:', error);
                });

            // Verificar el estado de la conexión
            window.Echo.connector.pusher.connection.bind('state_change', function(states) {
                console.log('📡 Estado de Pusher:', states.current);
                if (states.current === 'connected') {
                    console.log('✅ Conectado a Pusher correctamente');
                } else if (states.current === 'disconnected') {
                    console.log('⚠️ Desconectado de Pusher');
                } else if (states.current === 'failed') {
                    console.error('❌ Falló la conexión a Pusher');
                }
            });

            console.log('✅ WebSocket listener configurado correctamente');
        });

            // Función para mostrar toast
            function showToast(title, message, type = 'info') {
                const bgClass = type === 'success' ? 'bg-success' : 
                               type === 'warning' ? 'bg-warning' : 
                               type === 'danger' ? 'bg-danger' : 'bg-info';
                
                const toast = `
                    <div class="alert ${bgClass} text-white alert-dismissible fade show position-fixed top-0 end-0 m-3" 
                         style="z-index: 9999; min-width: 320px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" 
                         role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bell me-2"></i>
                            <div class="flex-grow-1">
                                <strong>${title}</strong><br>
                                <small>${message}</small>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                `;
                
                document.body.insertAdjacentHTML('beforeend', toast);
                
                // Auto-cerrar después de 7 segundos
                setTimeout(() => {
                    const lastAlert = document.querySelector('.alert:last-of-type');
                    if (lastAlert) {
                        lastAlert.classList.remove('show');
                        setTimeout(() => lastAlert.remove(), 300);
                    }
                }, 7000);
            }

            // Sonido de notificación
            function playNotificationSound() {
                try {
                    const audio = new Audio('data:audio/wav;base64,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');
                    audio.volume = 0.3;
                    audio.play().catch(e => console.log('🔇 No se pudo reproducir el sonido:', e));
                } catch (error) {
                    console.log('🔇 Error al reproducir sonido:', error);
                }
            }

            console.log('✅ WebSocket conectado correctamente para usuario ID: {{ Auth::id() }}');
        </script>
        @endauth
    </body>
</html>