<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes do Anúncio') }}
            </h2>

            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('admin.ads.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                Anúncios
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                {{ Str::limit($listing->title, 30) }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensagens -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Cartão principal -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Cabeçalho com ações -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 pb-6 border-b">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $listing->title }}</h1>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $listing->category->name ?? 'Sem categoria' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($listing->status === 'active') bg-green-100 text-green-800
                                    @elseif($listing->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @elseif($listing->status === 'sold') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($listing->status) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Criado em: {{ $listing->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <!-- Botões de ação -->
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                            <a href="{{ route('admin.ads.edit', $listing) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>

                            <form action="{{ route('admin.ads.destroy', $listing) }}" method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Tem certeza que deseja eliminar este anúncio permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>

                            <a href="{{ route('admin.ads.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Voltar
                            </a>
                        </div>
                    </div>

                    <!-- Grid de conteúdo -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Coluna 1: Imagens e informações principais -->
                        <div class="lg:col-span-2">
                            <!-- Galeria de imagens -->
                            @if($listing->images->count() > 0)
                                <div class="mb-8">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($listing->images as $image)
                                            <div class="relative group border rounded-lg overflow-hidden shadow-sm">
                                                <img src="{{ asset('storage/'.$image->path) }}"
                                                     alt="Imagem do anúncio"
                                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                                    #{{ $loop->iteration }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Descrição -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Descrição</h3>
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $listing->description }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna 2: Informações detalhadas -->
                        <div class="space-y-6">
                            <!-- Informações do anúncio -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Anúncio</h3>

                                <dl class="space-y-4">
                                    <!-- Preço -->
                                    @if($listing->price)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                            <dt class="text-sm font-medium text-gray-500">Preço</dt>
                                            <dd class="text-lg font-bold text-gray-900">
                                                {{ number_format($listing->price, 2, ',', '.') }} €
                                            </dd>
                                        </div>
                                    @endif

                                    <!-- Condição -->
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <dt class="text-sm font-medium text-gray-500">Condição</dt>
                                        <dd class="text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $listing->condition === 'new' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $listing->condition === 'new' ? 'Novo' : 'Usado' }}
                                            </span>
                                        </dd>
                                    </div>

                                    <!-- Localização -->
                                    @if($listing->location)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                            <dt class="text-sm font-medium text-gray-500">Localização</dt>
                                            <dd class="text-sm text-gray-900">{{ $listing->location }}</dd>
                                        </div>
                                    @endif

                                    <!-- Telefone -->
                                    @if($listing->phone)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                            <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a href="tel:{{ $listing->phone }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ $listing->phone }}
                                                </a>
                                            </dd>
                                        </div>
                                    @endif

                                    <!-- Email -->
                                    @if($listing->email)
                                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a href="mailto:{{ $listing->email }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ $listing->email }}
                                                </a>
                                            </dd>
                                        </div>
                                    @endif

                                    <!-- Slug/URL -->
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <dt class="text-sm font-medium text-gray-500">URL do anúncio</dt>
                                        <dd class="text-sm text-gray-900">
                                            <a href="{{ route('public.show', $listing->slug) }}"
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800 truncate block max-w-xs">
                                                {{ route('public.show', $listing->slug) }}
                                            </a>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Informações do criador -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Criador</h3>

                                <dl class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-500">Nome</dt>
                                        <dd class="text-sm text-gray-900">{{ $listing->user->name }}</dd>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $listing->user->email }}</dd>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-500">Data de criação</dt>
                                        <dd class="text-sm text-gray-900">{{ $listing->created_at->format('d/m/Y H:i') }}</dd>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <dt class="text-sm font-medium text-gray-500">Última atualização</dt>
                                        <dd class="text-sm text-gray-900">{{ $listing->updated_at->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Estatísticas -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                        <div class="text-2xl font-bold text-gray-900">{{ $listing->images->count() }}</div>
                                        <div class="text-sm text-gray-500">Imagens</div>
                                    </div>

                                    <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                        <div class="text-2xl font-bold text-gray-900">{{ strlen($listing->description) }}</div>
                                        <div class="text-sm text-gray-500">Caracteres</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé com ações adicionais -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap justify-between items-center">
                            <div class="text-sm text-gray-500">
                                ID do anúncio: <span class="font-mono">{{ $listing->id }}</span>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                                <!-- Botão para marcar como vendido -->
                                <form action="{{ route('admin.ads.update', $listing) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="sold">
                                    <button type="submit"
                                            onclick="return confirm('Marcar este anúncio como vendido?');"
                                            class="inline-flex items-center px-3 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Marcar como Vendido
                                    </button>
                                </form>

                                <!-- Botão para ativar/desativar -->
                                <form action="{{ route('admin.ads.update', $listing) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $listing->status === 'active' ? 'inactive' : 'active' }}">
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-2
                                                {{ $listing->status === 'active'
                                                    ? 'bg-yellow-600 hover:bg-yellow-700'
                                                    : 'bg-green-600 hover:bg-green-700' }}
                                                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($listing->status === 'active')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            @endif
                                        </svg>
                                        {{ $listing->status === 'active' ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para lightbox das imagens -->
    @push('scripts')
    <script>
        // Lightbox simples para imagens
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[alt="Imagem do anúncio"]');

            images.forEach((img, index) => {
                img.addEventListener('click', function() {
                    const lightbox = document.createElement('div');
                    lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
                    lightbox.innerHTML = `
                        <div class="relative max-w-4xl max-h-full">
                            <img src="${this.src}" class="max-w-full max-h-screen object-contain">
                            <button class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300" onclick="this.parentElement.parentElement.remove()">
                                &times;
                            </button>
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
                                Imagem ${index + 1} de ${images.length}
                            </div>
                        </div>
                    `;

                    // Fechar com ESC
                    lightbox.addEventListener('click', function(e) {
                        if (e.target === this) {
                            this.remove();
                        }
                    });

                    document.body.appendChild(lightbox);

                    // Adicionar teclas de navegação
                    document.addEventListener('keydown', function handleKey(e) {
                        if (e.key === 'Escape') {
                            lightbox.remove();
                            document.removeEventListener('keydown', handleKey);
                        }
                    });
                });

                // Adicionar cursor pointer
                img.style.cursor = 'pointer';
            });
        });
    </script>
    @endpush
</x-app-layout>
