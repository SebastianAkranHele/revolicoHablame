<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Anúncios') }}
            </h2>

            <!-- Estatísticas rápidas -->
            <div class="text-sm text-gray-600">
                Total: <span class="font-bold">{{ $listings->total() }}</span> anúncios
            </div>
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

            <!-- Barra de ações -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Botão Criar -->
                <div>
                    <a href="{{ route('admin.ads.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Novo Anúncio
                    </a>
                </div>

                <!-- Filtros rápidos -->
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-gray-600">Filtrar:</span>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('status') == 'active' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Ativos
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('status') == 'inactive' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Inativos
                    </a>
                    <a href="{{ route('admin.ads.index') }}"
                       class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                        Todos
                    </a>
                </div>
            </div>

            <!-- Tabela de anúncios -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Imagem
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Título
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Preço
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($listings as $listing)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Imagem -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($listing->images->first())
                                        <div class="relative group">
                                            <img src="{{ asset('storage/'.$listing->images->first()->path) }}"
                                                 alt="Imagem do anúncio"
                                                 class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                            @if($listing->images->count() > 1)
                                                <div class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                                    {{ $listing->images->count() }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <!-- Título -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin.ads.show', $listing) }}" class="hover:text-blue-600">
                                            {{ Str::limit($listing->title, 50) }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($listing->location, 30) }}
                                    </div>
                                </td>

                                <!-- Categoria -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($listing->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $listing->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Preço -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($listing->price)
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ number_format($listing->price, 2, ',', '.') }} €
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm">A negociar</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($listing->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Ativo
                                        </span>
                                    @elseif($listing->status === 'inactive')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Inativo
                                        </span>
                                    @elseif($listing->status === 'sold')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Vendido
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Data -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $listing->created_at->format('d/m/Y') }}</div>
                                    <div class="text-gray-400">{{ $listing->created_at->format('H:i') }}</div>
                                </td>

                                <!-- Ações -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Botão VER -->
                                        <a href="{{ route('admin.ads.show', $listing) }}"
                                           class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50"
                                           title="Ver detalhes">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Botão EDITAR -->
                                        <a href="{{ route('admin.ads.edit', $listing) }}"
                                           class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <!-- Botão ELIMINAR -->
                                        <form action="{{ route('admin.ads.destroy', $listing) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Tem certeza que deseja eliminar este anúncio?\nEsta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                                    title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium">Nenhum anúncio encontrado</p>
                                        <p class="mt-1">Comece criando o seu primeiro anúncio!</p>
                                        <a href="{{ route('admin.ads.create') }}"
                                           class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Criar Primeiro Anúncio
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                @if($listings->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando
                            <span class="font-medium">{{ $listings->firstItem() }}</span>
                            a
                            <span class="font-medium">{{ $listings->lastItem() }}</span>
                            de
                            <span class="font-medium">{{ $listings->total() }}</span>
                            resultados
                        </div>
                        <div>
                            {{ $listings->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Dicas rápidas -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-blue-800">Dica</span>
                    </div>
                    <p class="mt-1 text-sm text-blue-700">Clique no ícone 👁️ para ver todos os detalhes de um anúncio.</p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800">Status</span>
                    </div>
                    <p class="mt-1 text-sm text-green-700">Use os filtros para visualizar apenas anúncios ativos ou inativos.</p>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-sm font-medium text-purple-800">Segurança</span>
                    </div>
                    <p class="mt-1 text-sm text-purple-700">A ação de eliminar é permanente. Use com cuidado!</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Adicionar confirmação para eliminação
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('form[action*="/destroy"]');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('⚠️ ATENÇÃO!\n\nTem certeza que deseja eliminar este anúncio PERMANENTEMENTE?\n\nEsta ação eliminará todas as imagens e dados associados.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
