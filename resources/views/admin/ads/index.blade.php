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
                <div>
                    <a href="{{ route('admin.ads.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="bi bi-plus-circle mr-2"></i>
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
                                            <i class="bi bi-images text-gray-400 text-xl"></i>
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
                                            {{ number_format($listing->price, 2, ',', '.') }} KZ
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm">A negociar</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($listing->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Ativo
                                        </span>
                                    @elseif($listing->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Pendente
                                        </span>
                                    @elseif($listing->status === 'sold')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Vendido
                                        </span>
                                    @elseif($listing->status === 'expired')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="bi bi-circle-fill text-[8px] mr-1"></i>
                                            Expirado
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
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Botão EDITAR -->
                                        <a href="{{ route('admin.ads.edit', $listing) }}"
                                           class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- Botão VISUALIZAR PÚBLICO -->
                                        @if($listing->slug)
                                        <a href="{{ route('public.show', $listing->slug) }}"
                                           target="_blank"
                                           class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50"
                                           title="Visualizar público">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                        @endif

                                        <!-- Botão ELIMINAR -->
                                        <button type="button"
                                                onclick="confirmDeleteListing({{ $listing->id }}, '{{ $listing->title }}')"
                                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="bi bi-megaphone text-5xl text-gray-300 mb-4"></i>
                                        <p class="text-lg font-medium">Nenhum anúncio encontrado</p>
                                        <p class="mt-1">Comece criando o seu primeiro anúncio!</p>
                                        <a href="{{ route('admin.ads.create') }}"
                                           class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            <i class="bi bi-plus-circle mr-2"></i>
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

            <!-- Formulário oculto para eliminar -->
            <form id="deleteForm" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <!-- Dicas rápidas -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-info-circle text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-blue-800">Dica</span>
                    </div>
                    <p class="mt-1 text-sm text-blue-700">Clique no ícone 👁️ para ver todos os detalhes de um anúncio.</p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle text-green-600 mr-2"></i>
                        <span class="text-sm font-medium text-green-800">Status</span>
                    </div>
                    <p class="mt-1 text-sm text-green-700">Use os filtros para visualizar apenas anúncios por status.</p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-red-600 mr-2"></i>
                        <span class="text-sm font-medium text-red-800">Atenção</span>
                    </div>
                    <p class="mt-1 text-sm text-red-700">A ação de eliminar é permanente. Use com cuidado!</p>
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

        // 5. Inicializar eventos quando DOM carregar
        document.addEventListener('DOMContentLoaded', function() {
            // Adicionar botão de busca rápida se não existir
            const actionBar = document.querySelector('.flex.flex-col.sm\\:flex-row.sm\\:items-center.sm\\:justify-between.gap-4');
            if (actionBar) {
                const searchBtn = document.createElement('button');
                searchBtn.className = 'inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 transition ease-in-out duration-150';
                searchBtn.innerHTML = '<i class="bi bi-search mr-2"></i> Buscar';
                searchBtn.onclick = window.quickSearch;

                actionBar.querySelector('div:first-child').appendChild(searchBtn);
            }

            // Adicionar botão de exportar se não existir
            const exportBtn = document.createElement('button');
            exportBtn.className = 'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition ease-in-out duration-150 ml-2';
            exportBtn.innerHTML = '<i class="bi bi-download mr-2"></i> Exportar';
            exportBtn.onclick = window.exportListings;

            actionBar.querySelector('div:first-child').appendChild(exportBtn);

            // Adicionar tooltips aos ícones de ação
            const tooltips = {
                'bi-eye': 'Ver detalhes',
                'bi-pencil': 'Editar anúncio',
                'bi-box-arrow-up-right': 'Visualizar público',
                'bi-trash': 'Eliminar anúncio'
            };

            document.querySelectorAll('td .flex.items-center.space-x-2 a, td .flex.items-center.space-x-2 button').forEach(el => {
                const icon = el.querySelector('i');
                if (icon && tooltips[icon.className]) {
                    el.setAttribute('title', tooltips[icon.className]);

                    // Adicionar evento para SweetAlert2 tooltip
                    el.addEventListener('mouseenter', function(e) {
                        // Você pode adicionar tooltip personalizado aqui se quiser
                    });
                }
            });

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
        });

        // 6. Função para confirmar múltiplas eliminações (se implementar checkbox)
        window.confirmBulkDelete = function(selectedIds) {
            if (selectedIds.length === 0) {
                window.showWarning('Selecione pelo menos um anúncio para eliminar');
                return;
            }

            window.confirmDelete({
                title: 'Eliminar Múltiplos Anúncios',
                html: `Tem certeza que deseja eliminar <strong>${selectedIds.length}</strong> anúncios selecionados?<br><br>
                      <span class="text-red-600 font-medium">⚠️ Esta ação eliminará:</span>
                      <ul class="text-left list-disc pl-5 mt-2 text-sm">
                          <li>Todos os anúncios selecionados</li>
                          <li>Todas as imagens associadas</li>
                          <li>Esta ação não pode ser revertida!</li>
                      </ul>`,
                icon: 'error',
                confirmButtonText: `Sim, eliminar ${selectedIds.length}`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aqui você enviaria uma requisição AJAX para eliminar múltiplos
                    window.showLoading(`Eliminando ${selectedIds.length} anúncios...`);

                    // Simulação
                    setTimeout(() => {
                        window.showSuccess(`${selectedIds.length} anúncios eliminados com sucesso!`);
                        // Recarregar página
                        setTimeout(() => window.location.reload(), 1500);
                    }, 2000);
                }
            });
        };

        console.log('✅ SweetAlert2 configurado para lista de anúncios!');
    </script>

    <!-- Estilos adicionais -->
    <style>
        /* Melhorar responsividade da tabela */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .flex.flex-col.sm\\:flex-row {
                flex-direction: column;
                align-items: stretch;
            }

            .flex.flex-col.sm\\:flex-row > div {
                margin-bottom: 1rem;
            }

            .flex.space-x-2 {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        /* Melhorar hover das ações */
        td .flex.items-center.space-x-2 a,
        td .flex.items-center.space-x-2 button {
            transition: all 0.2s ease;
            padding: 0.25rem;
            border-radius: 0.375rem;
        }

        td .flex.items-center.space-x-2 a:hover,
        td .flex.items-center.space-x-2 button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Status badges com melhor visual */
        .inline-flex.items-center.px-2\\.5.py-0\\.5.rounded-full {
            transition: all 0.2s ease;
        }

        .inline-flex.items-center.px-2\\.5.py-0\\.5.rounded-full:hover {
            transform: scale(1.05);
        }

        /* Animações suaves */
        tr {
            transition: all 0.3s ease;
        }

        /* Loading spinner para ações */
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</x-app-layout>
