<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do Administrador') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total de Anúncios -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Anúncios</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $listingsCount }}</p>
                    <a href="{{ route('admin.ads.index') }}" class="text-sm text-blue-600 mt-4 hover:underline">Gerenciar
                        Anúncios →</a>
                </div>

                <!-- Total de Categorias -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Categorias</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $categoriesCount }}</p>
                    <a href="{{ route('admin.categories.index') }}"
                        class="text-sm text-blue-600 mt-4 hover:underline">Gerenciar Categorias →</a>
                </div>

                <!-- Total de Usuários -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Usuários</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $usersCount }}</p>
                </div>
            </div>

            <!-- Seção Últimos Anúncios -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-700">Últimos Anúncios</h3>
                    <a href="{{ route('admin.ads.index') }}" class="text-sm text-blue-600 hover:underline">
                        Ver todos →
                    </a>
                </div>

                @if($recentListings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentListings as $listing)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                <!-- Imagem do anúncio -->
                                <div class="relative h-48 overflow-hidden rounded-t-lg">
                                    @if ($listing->images->first())
                                        <img src="{{ asset('storage/' . $listing->images->first()->path) }}"
                                            alt="Imagem do anúncio"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Status badge -->
                                    <div class="absolute top-3 right-3">
                                        @if ($listing->status)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                Ativo
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                Inativo
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Conteúdo do card -->
                                <div class="p-4">
                                    <!-- Título -->
                                    <h4 class="font-medium text-gray-900 mb-2 line-clamp-1" title="{{ $listing->title }}">
                                        {{ $listing->title }}
                                    </h4>

                                    <!-- Informações -->
                                    <div class="space-y-2 mb-4">
                                        <!-- Categoria -->
                                        @if($listing->category)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                </svg>
                                                <span class="truncate">{{ $listing->category->name }}</span>
                                            </div>
                                        @endif

                                        <!-- Data -->
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $listing->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Botões de ação -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <a href="{{ route('admin.ads.edit', $listing) }}"
                                            class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Editar
                                        </a>

                                        <a href="{{ route('public.show', $listing->slug ?? '') }}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="text-gray-500">Nenhum anúncio recente.</p>
                        <a href="{{ route('admin.ads.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Criar Primeiro Anúncio
                        </a>
                    </div>
                @endif
            </div>

            <!-- Seção Últimos Usuários -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-700">Últimos Usuários Cadastrados</h3>
                    <span class="text-sm text-gray-500">{{ $recentUsers->count() }} usuários</span>
                </div>

                @if($recentUsers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentUsers as $user)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 p-5">
                                <div class="flex items-start space-x-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Informações do usuário -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Nome -->
                                        <h4 class="font-medium text-gray-900 mb-1 truncate" title="{{ $user->name }}">
                                            {{ $user->name }}
                                        </h4>

                                        <!-- Email -->
                                        <p class="text-sm text-gray-500 truncate mb-2" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </p>

                                        <!-- Data de cadastro -->
                                        <div class="flex items-center text-xs text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>Cadastrado em {{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>

                                        <!-- Contagem de anúncios (se disponível) -->
                                        @if(isset($user->listings_count))
                                            <div class="mt-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                    </svg>
                                                    {{ $user->listings_count }} anúncios
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Ações -->
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex space-x-2">
                                        <button class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Email
                                        </button>
                                        <button class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                            Perfil
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1a6 6 0 01-6 6m6-6a6 6 0 00-6-6m0 0a6 6 0 00-6 6"/>
                        </svg>
                        <p class="text-gray-500">Nenhum usuário recente.</p>
                    </div>
                @endif
            </div>

            <!-- Cards de Estatísticas Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Anúncios por Status -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Anúncios por Status</h3>
                    <div class="space-y-4">
                        @php
                            $statusStats = [
                                'ativos' => ['count' => $activeListingsCount ?? 0, 'color' => 'green', 'icon' => 'check-circle'],
                                'pendentes' => ['count' => $pendingListingsCount ?? 0, 'color' => 'yellow', 'icon' => 'clock'],
                                'vendidos' => ['count' => $soldListingsCount ?? 0, 'color' => 'purple', 'icon' => 'currency-dollar'],
                                'expirados' => ['count' => $expiredListingsCount ?? 0, 'color' => 'red', 'icon' => 'clock-history']
                            ];
                        @endphp

                        @foreach($statusStats as $status => $data)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-{{ $data['color'] }}-100 mr-3">
                                        <svg class="w-5 h-5 text-{{ $data['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($data['icon'] === 'check-circle')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @elseif($data['icon'] === 'clock')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @elseif($data['icon'] === 'currency-dollar')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 capitalize">{{ $status }}</span>
                                    </div>
                                </div>
                                <span class="text-lg font-semibold text-gray-900">{{ $data['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Ações Rápidas</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.ads.create') }}"
                           class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 flex flex-col items-center justify-center transition-colors duration-200 group">
                            <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-sm font-medium text-blue-700">Novo Anúncio</span>
                        </a>

                        <a href="{{ route('admin.categories.create') }}"
                           class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 flex flex-col items-center justify-center transition-colors duration-200 group">
                            <svg class="w-8 h-8 text-green-600 mb-2 group-hover:text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-sm font-medium text-green-700">Nova Categoria</span>
                        </a>

                        <a href="{{ route('admin.ads.index') }}?status=pending"
                           class="bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg p-4 flex flex-col items-center justify-center transition-colors duration-200 group">
                            <svg class="w-8 h-8 text-yellow-600 mb-2 group-hover:text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-yellow-700">Revisar Pendentes</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}"
                           class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 flex flex-col items-center justify-center transition-colors duration-200 group">
                            <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span class="text-sm font-medium text-purple-700">Gerenciar Categorias</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Estilos para os cards */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Efeitos de hover */
        .hover\:shadow-md {
            transition: all 0.3s ease;
        }

        .hover\:shadow-md:hover {
            transform: translateY(-2px);
        }

        /* Botões com efeito */
        .transition-colors {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Responsividade */
        @media (max-width: 640px) {
            .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            .grid.grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Animações suaves */
        .transition-shadow {
            transition: box-shadow 0.3s ease;
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        /* Cores dinâmicas para status */
        .bg-green-100 { background-color: #d1fae5; }
        .text-green-800 { color: #065f46; }
        .bg-red-100 { background-color: #fee2e2; }
        .text-red-800 { color: #991b1b; }
        .bg-yellow-100 { background-color: #fef3c7; }
        .text-yellow-800 { color: #92400e; }
        .bg-purple-100 { background-color: #e9d5ff; }
        .text-purple-800 { color: #5b21b6; }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-800 { color: #1e40af; }
    </style>
</x-app-layout>
