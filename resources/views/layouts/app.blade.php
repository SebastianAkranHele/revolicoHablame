<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hablame!') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head-scripts')

        <!-- Estilos responsivos -->
        <style>
            /* Estilos base responsivos */
            html {
                font-size: 16px;
            }

            @media (max-width: 640px) {
                html {
                    font-size: 14px;
                }
            }

            /* Ajustes para SweetAlert2 em mobile */
            @media (max-width: 640px) {
                .swal2-popup {
                    width: 90% !important;
                    margin-left: 5% !important;
                    margin-right: 5% !important;
                    font-size: 0.9rem !important;
                }

                .swal2-title {
                    font-size: 1.2rem !important;
                }

                .swal2-actions {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .swal2-confirm,
                .swal2-cancel {
                    width: 100% !important;
                    margin: 0 !important;
                }
            }

            /* Toasts responsivos */
            @media (max-width: 640px) {
                .swal2-toast {
                    width: 90% !important;
                    margin: 0.5rem auto !important;
                    font-size: 0.85rem !important;
                }
            }

            /* Ajuste para inputs em mobile */
            @media (max-width: 640px) {
                input, textarea, select {
                    font-size: 16px !important; /* Evita zoom em iOS */
                }

                input[type="text"],
                input[type="email"],
                input[type="tel"],
                input[type="number"],
                textarea,
                select {
                    padding: 0.75rem !important;
                }
            }

            /* Otimização para touch */
            button,
            a,
            .clickable {
                min-height: 44px;
                min-width: 44px;
            }

            /* Melhor espaçamento para toques */
            .touch-target {
                padding: 0.75rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <!-- Container principal -->
        <div class="min-h-screen flex flex-col">
            <!-- HEADER FIXO NO TOPO (responsivo) -->
            <div class="fixed top-0 inset-x-0 z-50 bg-white shadow-lg">
                <!-- Navigation do Breeze -->
                @include('layouts.navigation')

                <!-- Título da página (se existir) -->
                @if (isset($header))
                    <div class="border-t border-gray-200 bg-white">
                        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
                            <div class="py-2 sm:py-3">
                                <div class="text-sm sm:text-base">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- ESPAÇO PARA O HEADER FIXO (responsivo) -->
            <div class="h-20 sm:h-24 lg:h-28"></div>

            <!-- CONTEÚDO PRINCIPAL (responsivo) -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6">
                    <!-- Mensagens da sessão com SweetAlert2 -->
                    @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                window.showSuccess('{{ session('success') }}');
                            });
                        </script>
                    @endif

                    @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                window.showError('{{ session('error') }}');
                            });
                        </script>
                    @endif

                    @if(session('warning'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                window.showWarning('{{ session('warning') }}');
                            });
                        </script>
                    @endif

                    @if(session('info'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                window.showInfo('{{ session('info') }}');
                            });
                        </script>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <!-- FOOTER (opcional, se você tiver) -->
            @if(isset($footer) && $footer)
                <footer class="bg-white border-t border-gray-200 mt-auto">
                    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4">
                        {{ $footer }}
                    </div>
                </footer>
            @endif
        </div>

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Configuração global do SweetAlert2 com responsividade -->
        <script>
            // Configuração global do SweetAlert2
            const Swal = window.Swal;

            // Detectar se é mobile
            const isMobile = () => window.innerWidth <= 640;

            // Funções globais para usar em todo o projeto
            window.showSuccess = function(message, title = 'Sucesso!') {
                const config = {
                    icon: 'success',
                    title: title,
                    text: message,
                    toast: true,
                    position: isMobile() ? 'top' : 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#f0fdf4',
                    color: '#166534',
                    iconColor: '#22c55e',
                    width: isMobile() ? '90%' : 'auto',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                };

                Swal.fire(config);
            };

            window.showError = function(message, title = 'Erro!') {
                const config = {
                    icon: 'error',
                    title: title,
                    text: message,
                    toast: true,
                    position: isMobile() ? 'top' : 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    background: '#fef2f2',
                    color: '#991b1b',
                    iconColor: '#ef4444',
                    width: isMobile() ? '90%' : 'auto',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                };

                Swal.fire(config);
            };

            window.showWarning = function(message, title = 'Atenção!') {
                const config = {
                    icon: 'warning',
                    title: title,
                    text: message,
                    toast: true,
                    position: isMobile() ? 'top' : 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: '#fffbeb',
                    color: '#92400e',
                    iconColor: '#f59e0b',
                    width: isMobile() ? '90%' : 'auto',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                };

                Swal.fire(config);
            };

            window.showInfo = function(message, title = 'Informação') {
                const config = {
                    icon: 'info',
                    title: title,
                    text: message,
                    toast: true,
                    position: isMobile() ? 'top' : 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#eff6ff',
                    color: '#1e40af',
                    iconColor: '#3b82f6',
                    width: isMobile() ? '90%' : 'auto',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                };

                Swal.fire(config);
            };

            // Função para confirmações de exclusão (responsiva)
            window.confirmDelete = function(options = {}) {
                const defaults = {
                    title: 'Tem certeza?',
                    text: "Esta ação não pode ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, eliminar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    focusCancel: true,
                    width: isMobile() ? '90%' : 'auto',
                    customClass: {
                        confirmButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto',
                        cancelButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto',
                        actions: isMobile() ? 'flex-col !gap-2' : ''
                    },
                    buttonsStyling: false
                };

                const config = { ...defaults, ...options };

                return Swal.fire(config);
            };

            // Função para confirmações genéricas (responsiva)
            window.confirmAction = function(options = {}) {
                const defaults = {
                    title: 'Tem certeza?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    focusCancel: false,
                    width: isMobile() ? '90%' : 'auto',
                    customClass: {
                        confirmButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto',
                        cancelButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto',
                        actions: isMobile() ? 'flex-col !gap-2' : ''
                    },
                    buttonsStyling: false
                };

                const config = { ...defaults, ...options };

                return Swal.fire(config);
            };

            // Função para mostrar modal de carregamento
            window.showLoading = function(title = 'Carregando...') {
                Swal.fire({
                    title: title,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    width: isMobile() ? '90%' : 'auto',
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            };

            // Função para mostrar modal de sucesso (não toast)
            window.showModalSuccess = function(message, title = 'Sucesso!') {
                return Swal.fire({
                    icon: 'success',
                    title: title,
                    text: message,
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: 'OK',
                    width: isMobile() ? '90%' : 'auto',
                    customClass: {
                        confirmButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto'
                    },
                    buttonsStyling: false
                });
            };

            // Função para mostrar modal de erro (não toast)
            window.showModalError = function(message, title = 'Erro!') {
                return Swal.fire({
                    icon: 'error',
                    title: title,
                    text: message,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK',
                    width: isMobile() ? '90%' : 'auto',
                    customClass: {
                        confirmButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto'
                    },
                    buttonsStyling: false
                });
            };

            // Configuração para toasts responsivos
            const Toast = Swal.mixin({
                toast: true,
                position: () => isMobile() ? 'top' : 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                width: () => isMobile() ? '90%' : 'auto',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Expor Toast globalmente
            window.Toast = Toast;

            // Função para processar mensagens de sessão
            function processSessionMessages() {
                @if(session('swal'))
                    const swalData = @json(session('swal'));
                    if (swalData.type === 'success') {
                        window.showSuccess(swalData.message, swalData.title);
                    } else if (swalData.type === 'error') {
                        window.showError(swalData.message, swalData.title);
                    } else if (swalData.type === 'warning') {
                        window.showWarning(swalData.message, swalData.title);
                    } else if (swalData.type === 'info') {
                        window.showInfo(swalData.message, swalData.title);
                    }
                @endif

                // Verificar mensagens de validação
                @if($errors->any())
                    const errorMessages = [];
                    @foreach($errors->all() as $error)
                        errorMessages.push('{{ $error }}');
                    @endforeach

                    if (errorMessages.length > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro de Validação',
                            html: '<div class="text-left space-y-2">' +
                                  errorMessages.map(msg => `<p class="text-red-600">• ${msg}</p>`).join('') +
                                  '</div>',
                            confirmButtonText: 'Corrigir',
                            confirmButtonColor: '#dc2626',
                            width: isMobile() ? '90%' : 'auto',
                            customClass: {
                                confirmButton: 'px-4 py-3 sm:py-2 rounded-lg font-medium w-full sm:w-auto'
                            },
                            buttonsStyling: false
                        });
                    }
                @endif
            }

            // Processar mensagens quando o DOM carregar
            document.addEventListener('DOMContentLoaded', processSessionMessages);

            // Ajustar SweetAlert2 quando a janela for redimensionada
            window.addEventListener('resize', () => {
                // Os toasts já são responsivos via função isMobile()
                console.log('🔄 Tamanho da janela ajustado:', window.innerWidth);
            });

            // Debug
            console.log('✅ SweetAlert2 carregado com responsividade!');
        </script>

        <!-- Script para melhorar experiência mobile -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Prevenir zoom em inputs em iOS
                document.addEventListener('touchstart', function() {}, {passive: true});

                // Melhorar toques em botões
                const buttons = document.querySelectorAll('button, .btn, [role="button"]');
                buttons.forEach(button => {
                    if (!button.classList.contains('touch-target')) {
                        button.classList.add('touch-target');
                    }
                });

                // Ajustar font-size para inputs em mobile
                if (isMobile()) {
                    const inputs = document.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.style.fontSize = '16px';
                    });
                }

                // Detectar se é tablet (768px - 1024px)
                const isTablet = () => window.innerWidth >= 768 && window.innerWidth <= 1024;

                if (isTablet()) {
                    console.log('📱 Dispositivo tablet detectado');
                    // Adicionar classes específicas para tablet se necessário
                    document.body.classList.add('tablet-device');
                }

                if (isMobile()) {
                    console.log('📱 Dispositivo mobile detectado');
                    document.body.classList.add('mobile-device');
                }
            });

            // Função para detectar dispositivos
            function detectDevice() {
                const userAgent = navigator.userAgent;
                const isIOS = /iPad|iPhone|iPod/.test(userAgent) && !window.MSStream;
                const isAndroid = /Android/.test(userAgent);
                const isTablet = /iPad|Android(?!.*Mobile)/.test(userAgent) ||
                                (window.innerWidth >= 768 && window.innerWidth <= 1024);

                return {
                    isIOS,
                    isAndroid,
                    isTablet,
                    isMobile: isMobile(),
                    userAgent
                };
            }

            // Expor função globalmente
            window.detectDevice = detectDevice;

            // Log do dispositivo atual
            console.log('📱 Dispositivo detectado:', detectDevice());
        </script>

        @stack('scripts')
    </body>
</html>
