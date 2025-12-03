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

            <!-- Barra de ações -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Botão Criar -->
                <div class="flex space-x-2">
                    <a href="{{ route('admin.ads.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Novo Anúncio
                    </a>

                    <!-- Botão Buscar -->
                    <button onclick="window.quickSearch()"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 transition ease-in-out duration-150">
                        <i class="bi bi-search mr-2"></i> Buscar
                    </button>

                    <!-- Botão Exportar -->
                    <button onclick="window.exportListings()"
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition ease-in-out duration-150">
                        <i class="bi bi-download mr-2"></i> Exportar
                    </button>
                </div>

                <!-- Filtros rápidos -->
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-gray-600">Filtrar:</span>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('status') == 'active' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Ativos
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Pendentes
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'sold']) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('status') == 'sold' ? 'bg-purple-100 text-purple-800 border border-purple-300' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                        Vendidos
                    </a>
                    <a href="{{ route('admin.ads.index') }}"
                       class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                        Todos
                    </a>
                </div>
            </div>

            <!-- Cards de anúncios -->
            @if($listings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($listings as $listing)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Imagem principal -->
                            <div class="relative h-48 overflow-hidden">
                                @if($listing->images->first())
                                    <img src="{{ asset('storage/'.$listing->images->first()->path) }}"
                                         alt="{{ $listing->title }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @if($listing->images->count() > 1)
                                        <div class="absolute top-3 right-3 bg-blue-600 text-white text-xs rounded-full w-8 h-8 flex items-center justify-center shadow-md">
                                            +{{ $listing->images->count() - 1 }}
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="bi bi-images text-gray-400 text-4xl"></i>
                                    </div>
                                @endif

                                <!-- Status badge -->
                                <div class="absolute top-3 left-3">
                                    @if($listing->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Ativo
                                        </span>
                                    @elseif($listing->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 shadow">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Pendente
                                        </span>
                                    @elseif($listing->status === 'sold')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 shadow">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Vendido
                                        </span>
                                    @elseif($listing->status === 'expired')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 shadow">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Expirado
                                        </span>
                                    @endif
                                </div>

                                <!-- Preço -->
                                @if($listing->price)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-white/90 backdrop-blur-sm text-gray-900 shadow">
                                            {{ number_format($listing->price, 2, ',', '.') }} KZ
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Conteúdo do card -->
                            <div class="p-4">
                                <!-- Categoria -->
                                @if($listing->category)
                                    <div class="mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $listing->category->name }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Título -->
                                <h3 class="font-semibold text-gray-900 mb-1 truncate" title="{{ $listing->title }}">
                                    <a href="{{ route('admin.ads.show', $listing) }}" class="hover:text-blue-600">
                                        {{ $listing->title }}
                                    </a>
                                </h3>

                                <!-- Localização -->
                                @if($listing->location)
                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <i class="bi bi-geo-alt mr-1"></i>
                                        <span class="truncate" title="{{ $listing->location }}">
                                            {{ Str::limit($listing->location, 30) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Informações adicionais -->
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                    <div class="flex items-center">
                                        <i class="bi bi-calendar mr-1"></i>
                                        {{ $listing->created_at->format('d/m/Y') }}
                                    </div>

                                    @if($listing->views_count)
                                        <div class="flex items-center">
                                            <i class="bi bi-eye mr-1"></i>
                                            {{ $listing->views_count }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Botões de ação -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <!-- Botão VER -->
                                    <a href="{{ route('admin.ads.show', $listing) }}"
                                       class="flex-1 flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200 mr-2"
                                       title="Ver detalhes">
                                        <i class="bi bi-eye mr-2"></i>
                                        
                                    </a>

                                    <!-- Botão EDITAR -->
                                    <a href="{{ route('admin.ads.edit', $listing) }}"
                                       class="flex-1 flex items-center justify-center px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors duration-200 mr-2"
                                       title="Editar">
                                        <i class="bi bi-pencil mr-2"></i>

                                    </a>

                                    <!-- Botão VISUALIZAR PÚBLICO -->
                                    @if($listing->slug)
                                        <a href="{{ route('public.show', $listing->slug) }}"
                                           target="_blank"
                                           class="flex-1 flex items-center justify-center px-3 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors duration-200 mr-2"
                                           title="Visualizar público">
                                            <i class="bi bi-box-arrow-up-right mr-2"></i>

                                        </a>
                                    @endif

                                    <!-- Botão ELIMINAR -->
                                    <button type="button"
                                            onclick="confirmDeleteListing({{ $listing->id }}, '{{ addslashes($listing->title) }}')"
                                            class="flex-1 flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors duration-200"
                                            title="Eliminar">
                                        <i class="bi bi-trash mr-2"></i>

                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vazio -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                        <i class="bi bi-megaphone text-6xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium mb-2">Nenhum anúncio encontrado</p>
                        <p class="text-gray-600 mb-6">Comece criando o seu primeiro anúncio!</p>
                        <a href="{{ route('admin.ads.create') }}"
                           class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Criar Primeiro Anúncio
                        </a>
                    </div>
                </div>
            @endif

            <!-- Paginação -->
            @if($listings->hasPages())
                <div class="mt-8 bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 mb-4 sm:mb-0">
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
                </div>
            @endif

            <!-- Formulário oculto para eliminar -->
            <form id="deleteForm" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <!-- Dicas rápidas -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-info-circle text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-blue-800">Dica</span>
                    </div>
                    <p class="mt-1 text-sm text-blue-700">Passe o mouse sobre as imagens para ver o efeito de zoom.</p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle text-green-600 mr-2"></i>
                        <span class="text-sm font-medium text-green-800">Status</span>
                    </div>
                    <p class="mt-1 text-sm text-green-700">Identifique rapidamente o status pelo badge colorido no canto superior esquerdo.</p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-red-600 mr-2"></i>
                        <span class="text-sm font-medium text-red-800">Atenção</span>
                    </div>
                    <p class="mt-1 text-sm text-red-700">A ação de eliminar é permanente. Todos os dados serão perdidos!</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================
        // FUNÇÕES PARA AÇÃO DE ELIMINAR COM SWEETALERT2
        // ============================================

        // 1. Função para confirmar eliminação de anúncio
        window.confirmDeleteListing = function(listingId, listingTitle) {
            window.confirmDelete({
                title: 'Eliminar Anúncio',
                html: `Tem certeza que deseja eliminar o anúncio:<br><strong>"${listingTitle}"</strong>?<br><br>
                      <span class="text-red-600 font-medium">⚠️ Esta ação eliminará:</span>
                      <ul class="text-left list-disc pl-5 mt-2 text-sm">
                          <li>O anúncio permanentemente</li>
                          <li>Todas as imagens associadas</li>
                          <li>Dados de visualizações e interesses</li>
                      </ul>
                      <p class="mt-3 text-red-600 font-bold">Esta ação não pode ser revertida!</p>`,
                icon: 'error',
                confirmButtonText: 'Sim, eliminar!',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                focusCancel: true,
                customClass: {
                    confirmButton: 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg',
                    cancelButton: 'px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    window.showLoading('Eliminando anúncio...');

                    // Construir URL e formulário
                    const url = `/admin/ads/${listingId}`;
                    const form = document.getElementById('deleteForm');
                    form.action = url;

                    // Enviar formulário com delay para mostrar loading
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        };

        // 2. Função para alterar status rápido
        window.changeListingStatus = function(listingId, currentStatus, listingTitle) {
            const statusOptions = {
                'active': { label: 'Ativo', color: 'green', icon: 'check-circle' },
                'pending': { label: 'Pendente', color: 'yellow', icon: 'clock' },
                'sold': { label: 'Vendido', color: 'purple', icon: 'currency-dollar' },
                'expired': { label: 'Expirado', color: 'red', icon: 'clock-history' }
            };

            // Criar opções de status
            let statusHtml = '<div class="text-left space-y-2">';
            for (const [key, value] of Object.entries(statusOptions)) {
                const isCurrent = key === currentStatus;
                statusHtml += `
                    <div class="flex items-center p-2 rounded hover:bg-gray-50 cursor-pointer ${isCurrent ? 'bg-gray-100' : ''}"
                         onclick="selectStatus('${key}', '${value.label}', '${value.color}')">
                        <i class="bi bi-${value.icon} text-${value.color}-600 mr-2"></i>
                        <span class="flex-1">${value.label}</span>
                        ${isCurrent ? '<i class="bi bi-check text-green-600"></i>' : ''}
                    </div>
                `;
            }
            statusHtml += '</div>';

            Swal.fire({
                title: 'Alterar Status',
                html: `Alterar status do anúncio:<br><strong>"${listingTitle}"</strong><br><br>${statusHtml}`,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                width: '400px',
                didOpen: () => {
                    // Adicionar evento de clique nas opções
                    window.selectStatus = function(status, label, color) {
                        // Confirmar alteração
                        Swal.fire({
                            title: 'Confirmar Alteração',
                            html: `Deseja alterar o status para: <span class="font-bold text-${color}-600">${label}</span>?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Sim, alterar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Enviar requisição AJAX para alterar status
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                                fetch(`/admin/ads/${listingId}/status`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ status: status })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.showSuccess('Status alterado com sucesso!');
                                        // Recarregar a página após 1.5 segundos
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1500);
                                    } else {
                                        window.showError(data.message || 'Erro ao alterar status');
                                    }
                                })
                                .catch(error => {
                                    window.showError('Erro ao alterar status: ' + error.message);
                                });
                            }
                        });
                    };
                }
            });
        };

        // 3. Função para busca rápida
        window.quickSearch = function() {
            Swal.fire({
                title: 'Buscar Anúncios',
                input: 'text',
                inputPlaceholder: 'Digite título, categoria ou localização...',
                showCancelButton: true,
                confirmButtonText: 'Buscar',
                cancelButtonText: 'Cancelar',
                width: '500px',
                preConfirm: (searchTerm) => {
                    if (!searchTerm) {
                        Swal.showValidationMessage('Por favor, digite um termo para buscar');
                        return false;
                    }

                    // Redirecionar para busca
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', searchTerm);
                    window.location.href = url.toString();
                }
            });
        };

        // 4. Função para exportar dados
        window.exportListings = function() {
            Swal.fire({
                title: 'Exportar Anúncios',
                html: `
                    <div class="text-left space-y-4">
                        <p class="text-gray-700">Selecione o formato de exportação:</p>

                        <div class="space-y-2">
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="exportFormat" value="csv" class="mr-3" checked>
                                <div>
                                    <div class="font-medium">CSV (Excel)</div>
                                    <div class="text-sm text-gray-500">Ideal para planilhas e análise de dados</div>
                                </div>
                            </label>

                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="exportFormat" value="pdf" class="mr-3">
                                <div>
                                    <div class="font-medium">PDF</div>
                                    <div class="text-sm text-gray-500">Para impressão ou compartilhamento formal</div>
                                </div>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por:</label>
                            <select id="exportFilter" class="w-full border-gray-300 rounded-lg">
                                <option value="all">Todos os anúncios</option>
                                <option value="active">Apenas ativos</option>
                                <option value="sold">Apenas vendidos</option>
                                <option value="this_month">Este mês</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Exportar',
                cancelButtonText: 'Cancelar',
                width: '500px',
                preConfirm: () => {
                    const format = document.querySelector('input[name="exportFormat"]:checked').value;
                    const filter = document.getElementById('exportFilter').value;

                    // Mostrar loading
                    Swal.fire({
                        title: 'Preparando exportação...',
                        text: 'Por favor, aguarde enquanto processamos seus dados.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Simular exportação (substituir por requisição real)
                    setTimeout(() => {
                        window.showSuccess(`Exportação ${format.toUpperCase()} iniciada! Os dados serão baixados em breve.`);

                        // Aqui você faria a requisição real para exportar
                        // window.location.href = `/admin/ads/export?format=${format}&filter=${filter}`;
                    }, 1500);

                    return false; // Não fechar o modal ainda
                }
            });
        };

        // Configurar mensagens de sessão com SweetAlert2
        @if(session('success'))
            window.showSuccess('{{ session('success') }}');
        @endif

        @if(session('error'))
            window.showError('{{ session('error') }}');
        @endif

        @if(session('warning'))
            window.showWarning('{{ session('warning') }}');
        @endif

        console.log('✅ Cards de anúncios configurados!');
    </script>

    <!-- Estilos adicionais -->
    <style>
        /* Efeito de hover nos cards */
        .bg-white.rounded-lg.shadow-md {
            transition: all 0.3s ease;
        }

        .bg-white.rounded-lg.shadow-md:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Botões de ação responsivos */
        @media (max-width: 640px) {
            .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
                grid-template-columns: 1fr;
            }

            .flex.items-center.justify-between.pt-3 {
                flex-wrap: wrap;
            }

            .flex.items-center.justify-between.pt-3 > * {
                flex: 0 0 calc(50% - 0.5rem);
                margin-bottom: 0.5rem;
            }
        }

        /* Animações suaves para imagens */
        .relative.h-48.overflow-hidden img {
            transition: transform 0.5s ease;
        }

        /* Badges de status com sombra */
        .inline-flex.items-center.px-2\\.5.py-1.rounded-full {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Botões de ação com efeito */
        .flex.items-center.justify-center.px-3.py-2 {
            transition: all 0.2s ease;
        }

        .flex.items-center.justify-center.px-3.py-2:hover {
            transform: translateY(-1px);
        }

        /* Responsividade para paginação */
        @media (max-width: 640px) {
            .flex.flex-col.sm\:flex-row.sm\:items-center.sm\:justify-between {
                text-align: center;
            }

            .text-sm.text-gray-700.mb-4 {
                margin-bottom: 1rem;
            }
        }

        /* Tooltips para botões de ação */
        [title] {
            position: relative;
        }

        [title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 0.25rem;
        }
    </style>
</x-app-layout>
