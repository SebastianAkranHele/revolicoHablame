<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-16 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard')" :active="request()->routeIs(auth()->user()->is_admin ? 'admin.dashboard' : 'dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (auth()->user()->is_admin)
                        <x-nav-link :href="route('admin.ads.index')" :active="request()->routeIs('admin.ads.*')">
                            {{ __('Anúncios') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Categorias') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Logout only) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Formulário de logout com SweetAlert2 -->
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                            @csrf
                            <x-dropdown-link href="#"
                                onclick="event.preventDefault(); confirmLogout();"
                                class="text-red-600 hover:bg-red-50">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    {{ __('Sair') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard')" :active="request()->routeIs(auth()->user()->is_admin ? 'admin.dashboard' : 'dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->is_admin)
                <x-responsive-nav-link :href="route('admin.ads.index')" :active="request()->routeIs('admin.ads.*')">
                    {{ __('Anúncios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Categorias') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Formulário de logout mobile com SweetAlert2 -->
                <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                    @csrf
                    <x-responsive-nav-link href="#"
                        onclick="event.preventDefault(); confirmLogout();"
                        class="text-red-600 hover:bg-red-50">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Sair') }}
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para confirmar logout com SweetAlert2 -->
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Sair da Conta',
                text: 'Tem certeza que deseja sair do sistema?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                customClass: {
                    confirmButton: 'px-4 py-2 rounded-lg font-medium',
                    cancelButton: 'px-4 py-2 rounded-lg font-medium'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Encontrar e submeter o formulário correto
                    const desktopForm = document.getElementById('logout-form-desktop');
                    const mobileForm = document.getElementById('logout-form-mobile');

                    if (desktopForm) {
                        desktopForm.submit();
                    } else if (mobileForm) {
                        mobileForm.submit();
                    }
                }
            });
        }

        // Adicionar funcionalidade ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Menu de navegação carregado com SweetAlert2 para logout');
        });
    </script>
</nav>
