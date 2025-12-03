<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Barra de ações superiores -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-medium text-gray-900">Gerenciamento de Categorias</h3>
                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                    {{ $categories->total() }} categorias
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <button onclick="exportCategories()"
                   class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar CSV
                </button>
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Categoria
                </a>
            </div>
        </div>

        <!-- Barra de ações em massa -->
        <div id="bulk-actions" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <span id="selected-count" class="font-medium text-blue-800">0</span>
                    <span class="text-blue-700"> categorias selecionadas</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button id="bulk-activate"
                            class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ativar selecionados
                    </button>
                    <button id="bulk-deactivate"
                            class="inline-flex items-center gap-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Desativar selecionados
                    </button>
                    <button id="bulk-delete-btn"
                            class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Excluir selecionados
                    </button>
                </div>
            </div>
        </div>

        <!-- Cards de Categorias -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="sortable-cards">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 sortable-card" data-id="{{ $category->id }}">
                        <!-- Cabeçalho do Card -->
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <!-- Checkbox -->
                            <div class="flex items-center">
                                <input type="checkbox"
                                       value="{{ $category->id }}"
                                       class="select-item rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            
                            <!-- Ordem -->
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                Ordem: {{ $category->order }}
                            </span>
                        </div>

                        <!-- Conteúdo do Card -->
                        <div class="p-4">
                            <!-- Ícone e Nome -->
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        @if($category->icon === 'box')
                                            <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5z" clip-rule="evenodd"/>
                                        @elseif($category->icon === 'tv')
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                        @elseif($category->icon === 'car-front')
                                            <path fill-rule="evenodd" d="M2.5 7.5A.5.5 0 013 7h10a.5.5 0 01.5.5v7a.5.5 0 01-.5.5H3a.5.5 0 01-.5-.5v-7zM4 8v6h8V8H4z"/>
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V5a1 1 0 00-1-1H4z"/>
                                        @elseif($category->icon === 'house-door')
                                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</h3>
                                    <p class="text-xs text-gray-500 truncate">{{ $category->slug }}</p>
                                    @if($category->description)
                                        <p class="text-xs text-gray-400 mt-1 line-clamp-2">
                                            {{ $category->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Ícone -->
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $category->icon }}
                                </span>
                            </div>

                            <!-- Hierarquia -->
                            <div class="space-y-2 mb-4">
                                @if($category->parent)
                                    <div class="flex items-center text-sm text-gray-700 bg-gray-50 p-2 rounded">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="truncate">Pai: {{ $category->parent->name }}</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Categoria Principal
                                    </span>
                                @endif
                                
                                @if($category->children_count > 0)
                                    <div class="flex items-center text-sm text-gray-600 bg-green-50 p-2 rounded">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                        {{ $category->children_count }} subcategorias
                                    </div>
                                @endif
                            </div>

                            <!-- Estatísticas -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Anúncios</div>
                                    @php
                                        $listingsCount = $category->listings_count ?? $category->listings()->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $listingsCount > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $listingsCount }}
                                    </span>
                                </div>

                                <!-- Status -->
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Status</div>
                                    <button type="button"
                                            onclick="toggleCategoryStatus({{ $category->id }}, '{{ $category->name }}', {{ $category->is_active ? 'true' : 'false' }})"
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium transition {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        @if($category->is_active)
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Ativa
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Inativa
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Rodapé do Card - Botões de Ação -->
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <!-- Botão Editar -->
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                                   title="Editar">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-xs font-medium">Editar</span>
                                </a>

                                <!-- Botão Duplicar -->
                                <button type="button"
                                        onclick="duplicateCategory({{ $category->id }}, '{{ $category->name }}')"
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors duration-200"
                                        title="Duplicar">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs font-medium">Duplicar</span>
                                </button>

                                <!-- Botão Excluir -->
                                <button type="button"
                                        onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}', {{ $listingsCount }})"
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors duration-200"
                                        title="Excluir">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="text-xs font-medium">Excluir</span>
                                </button>
                            </div>
                            
                            <!-- Handle para arrastar -->
                            <div class="mt-2 pt-2 border-t border-gray-200">
                                <button type="button"
                                        class="w-full flex items-center justify-center text-gray-400 hover:text-gray-600 transition cursor-move handle"
                                        title="Arrastar para reordenar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                    <span class="text-xs ml-1">Arrastar para reordenar</span>
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
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">Nenhuma categoria encontrada</p>
                    <p class="text-gray-600 mb-6">Comece criando sua primeira categoria</p>
                    <a href="{{ route('admin.categories.create') }}"
                       class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Categoria
                    </a>
                </div>
            </div>
        @endif

        <!-- Paginação -->
        @if($categories->hasPages())
            <div class="mt-8 bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                            Mostrando
                            <span class="font-medium">{{ $categories->firstItem() }}</span>
                            a
                            <span class="font-medium">{{ $categories->lastItem() }}</span>
                            de
                            <span class="font-medium">{{ $categories->total() }}</span>
                            resultados
                        </div>
                        <div>
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Checkbox para selecionar todos (flutuante em telas pequenas) -->
        <div class="fixed bottom-4 right-4 sm:hidden">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" id="select-all-mobile" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-medium">Selecionar todos</span>
                </label>
            </div>
        </div>

        <!-- Formulário oculto para ações -->
        <form id="action-form" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        // ============================================
        // FUNÇÕES SWEETALERT2 PARA CATEGORIAS
        // ============================================

        // 1. Função para alternar status da categoria
        window.toggleCategoryStatus = function(categoryId, categoryName, isActive) {
            const newStatus = !isActive;
            const statusText = newStatus ? 'ativar' : 'desativar';
            const statusIcon = newStatus ? 'success' : 'warning';
            
            Swal.fire({
                title: `${newStatus ? 'Ativar' : 'Desativar'} Categoria`,
                html: `Deseja ${statusText} a categoria <strong>"${categoryName}"</strong>?`,
                icon: statusIcon,
                showCancelButton: true,
                confirmButtonText: `Sim, ${statusText}`,
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: `px-4 py-2 bg-${newStatus ? 'green' : 'yellow'}-600 hover:bg-${newStatus ? 'green' : 'yellow'}-700 text-white rounded-lg`,
                    cancelButton: 'px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: `${newStatus ? 'Ativando' : 'Desativando'}...`,
                        text: 'Por favor, aguarde.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar requisição
                    const form = document.getElementById('action-form');
                    form.action = `/admin/categories/${categoryId}/toggle-status`;
                    
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        };

        // 2. Função para duplicar categoria
        window.duplicateCategory = function(categoryId, categoryName) {
            Swal.fire({
                title: 'Duplicar Categoria',
                html: `Deseja criar uma cópia da categoria <strong>"${categoryName}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, duplicar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg',
                    cancelButton: 'px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Duplicando...',
                        text: 'Criando cópia da categoria.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar requisição
                    const form = document.getElementById('action-form');
                    form.action = `/admin/categories/${categoryId}/duplicate`;
                    
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        };

        // 3. Função para excluir categoria
        window.deleteCategory = function(categoryId, categoryName, listingsCount) {
            let warningHtml = '';
            
            if (listingsCount > 0) {
                warningHtml = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mt-3">
                        <div class="flex items-center text-red-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="font-bold">ATENÇÃO:</span>
                        </div>
                        <p class="text-red-600 text-sm mt-1">
                            Esta categoria possui <strong>${listingsCount} anúncio(s)</strong> vinculados.<br>
                            Ao excluir, os anúncios ficarão sem categoria associada.
                        </p>
                    </div>
                `;
            }

            Swal.fire({
                title: 'Excluir Categoria',
                html: `
                    <div class="text-left">
                        <p>Tem certeza que deseja excluir a categoria:</p>
                        <p class="font-bold text-lg text-center my-3">"${categoryName}"</p>
                        ${warningHtml}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-3">
                            <p class="text-gray-700 text-sm">
                                <span class="font-bold">⚠️ Esta ação eliminará:</span>
                            </p>
                            <ul class="text-left list-disc pl-5 mt-2 text-sm text-gray-600">
                                <li>A categoria permanentemente</li>
                                <li>A ordem será reajustada</li>
                                <li>Subcategorias se tornarão categorias principais</li>
                            </ul>
                            <p class="mt-3 text-red-600 font-bold">Esta ação não pode ser revertida!</p>
                        </div>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    confirmButton: 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg',
                    cancelButton: 'px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Excluindo...',
                        text: 'Removendo categoria e ajustando dados.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar requisição
                    const form = document.getElementById('action-form');
                    form.action = `/admin/categories/${categoryId}`;
                    
                    // Adicionar method DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        };

        // 4. Função para exportar categorias
        window.exportCategories = function() {
            Swal.fire({
                title: 'Exportar Categorias',
                html: `
                    <div class="text-left space-y-4">
                        <p class="text-gray-700">Escolha o formato de exportação:</p>
                        
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="exportType" value="csv" class="mr-3" checked>
                                <div>
                                    <div class="font-medium">CSV (Excel)</div>
                                    <div class="text-sm text-gray-500">Formato padrão para planilhas</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="exportType" value="json" class="mr-3">
                                <div>
                                    <div class="font-medium">JSON</div>
                                    <div class="text-sm text-gray-500">Para integração com outros sistemas</div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Incluir:</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="includeChildren" class="mr-2 rounded border-gray-300" checked>
                                    <span class="text-sm">Subcategorias</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="includeStats" class="mr-2 rounded border-gray-300" checked>
                                    <span class="text-sm">Estatísticas (número de anúncios)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Exportar',
                cancelButtonText: 'Cancelar',
                width: '500px',
                preConfirm: () => {
                    const exportType = document.querySelector('input[name="exportType"]:checked').value;
                    const includeChildren = document.querySelector('input[name="includeChildren"]').checked;
                    const includeStats = document.querySelector('input[name="includeStats"]').checked;
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Preparando exportação...',
                        text: 'Processando dados das categorias.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Redirecionar para exportação
                    setTimeout(() => {
                        window.location.href = `/admin/categories/export?type=${exportType}&children=${includeChildren ? 1 : 0}&stats=${includeStats ? 1 : 0}`;
                    }, 1500);

                    return false;
                }
            });
        };

        // 5. Função para ações em massa com SweetAlert2
        window.confirmBulkAction = function(action, count, color, title, url, data) {
            const actionText = action === 'ativar' ? 'ativação' : 
                             action === 'desativar' ? 'desativação' : 'exclusão';
            const actionIcon = action === 'ativar' ? 'success' : 
                             action === 'desativar' ? 'warning' : 'error';
            
            let warningHtml = '';
            if (action === 'excluir') {
                warningHtml = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mt-3">
                        <div class="flex items-center text-red-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="font-bold">ATENÇÃO CRÍTICA:</span>
                        </div>
                        <p class="text-red-600 text-sm mt-1">
                            <strong>Esta ação não pode ser revertida!</strong><br>
                            Todas as categorias selecionadas serão removidas permanentemente.
                        </p>
                    </div>
                `;
            }

            Swal.fire({
                title: title,
                html: `
                    <div class="text-left">
                        <p>Deseja ${action} <strong>${count} categoria(s)</strong> selecionadas?</p>
                        ${warningHtml}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-3">
                            <p class="text-gray-700 text-sm">
                                <span class="font-bold">📋 Categorias selecionadas:</span> ${count}
                            </p>
                            <p class="text-gray-600 text-sm mt-1">
                                Esta ${actionText} será aplicada a todas as categorias selecionadas.
                            </p>
                        </div>
                    </div>
                `,
                icon: actionIcon,
                showCancelButton: true,
                confirmButtonText: `Sim, ${action} ${count}`,
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                focusCancel: action === 'excluir',
                customClass: {
                    confirmButton: `px-4 py-2 bg-${color}-600 hover:bg-${color}-700 text-white rounded-lg`,
                    cancelButton: 'px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: `${action === 'ativar' ? 'Ativando' : action === 'desativar' ? 'Desativando' : 'Excluindo'}...`,
                        text: `Processando ${count} categoria(s).`,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar requisição AJAX
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...data,
                            ids: Array.from(window.selectedItems || new Set())
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: data.message || `${count} categoria(s) ${action}(s) com sucesso!`,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: data.message || `Ocorreu um erro ao ${action} as categorias.`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao processar a solicitação.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        };

        // 6. Inicialização quando o DOM carrega
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar seleção múltipla
            window.selectedItems = new Set();

            // Toggle select all (mobile)
            $('#select-all-mobile').change(function() {
                const isChecked = this.checked;
                $('.select-item').prop('checked', isChecked);
                
                if (isChecked) {
                    $('.select-item').each(function() {
                        window.selectedItems.add($(this).val());
                    });
                } else {
                    window.selectedItems.clear();
                }
                updateBulkActions();
            });

            // Toggle individual items
            $('.select-item').change(function() {
                const value = $(this).val();

                if (this.checked) {
                    window.selectedItems.add(value);
                } else {
                    window.selectedItems.delete(value);
                    $('#select-all-mobile').prop('checked', false);
                }
                updateBulkActions();
            });

            // Update bulk actions bar
            function updateBulkActions() {
                const count = window.selectedItems.size;
                $('#selected-count').text(count);

                if (count > 0) {
                    $('#bulk-actions').removeClass('hidden');
                } else {
                    $('#bulk-actions').addClass('hidden');
                }
            }

            // Bulk activate
            $('#bulk-activate').click(function() {
                if (window.selectedItems.size === 0) return;
                
                window.confirmBulkAction(
                    'ativar',
                    window.selectedItems.size,
                    'green',
                    'Ativar Categorias Selecionadas',
                    '{{ route("admin.categories.bulk-status") }}',
                    { status: 1 }
                );
            });

            // Bulk deactivate
            $('#bulk-deactivate').click(function() {
                if (window.selectedItems.size === 0) return;
                
                window.confirmBulkAction(
                    'desativar',
                    window.selectedItems.size,
                    'yellow',
                    'Desativar Categorias Selecionadas',
                    '{{ route("admin.categories.bulk-status") }}',
                    { status: 0 }
                );
            });

            // Bulk delete
            $('#bulk-delete-btn').click(function() {
                if (window.selectedItems.size === 0) return;
                
                window.confirmBulkAction(
                    'excluir',
                    window.selectedItems.size,
                    'red',
                    'Excluir Categorias Selecionadas',
                    '{{ route("admin.categories.bulk-delete") }}',
                    {}
                );
            });

            // Inicializar sortable para cards
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.sortable !== 'undefined') {
                $('#sortable-cards').sortable({
                    handle: '.handle, .sortable-card',
                    items: '.sortable-card',
                    opacity: 0.7,
                    placeholder: 'sortable-placeholder',
                    start: function(e, ui) {
                        ui.placeholder.height(ui.helper.outerHeight());
                        ui.placeholder.width(ui.helper.outerWidth());
                        ui.helper.addClass('shadow-xl');
                    },
                    update: function(event, ui) {
                        const ids = [];
                        $('#sortable-cards .sortable-card').each(function() {
                            ids.push($(this).data('id'));
                        });

                        // Enviar requisição AJAX
                        fetch('{{ route("admin.categories.reorder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ ids: ids })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mostrar notificação de sucesso
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Ordem atualizada com sucesso!'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao atualizar ordem:', error);
                        });
                    }
                });
            }

            // Desabilitar sortable no clique do checkbox
            $('.select-item, #select-all-mobile').click(function(e) {
                e.stopPropagation();
            });

            // Configurar mensagens de sessão com SweetAlert2
            @if(session('success'))
                Swal.fire({
                    title: 'Sucesso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            console.log('✅ SweetAlert2 configurado para categorias!');
        });
    </script>

    <!-- Estilos adicionais -->
    <style>
        /* Estilos para os cards */
        .sortable-card {
            transition: all 0.3s ease;
        }

        .sortable-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .sortable-placeholder {
            background-color: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            height: 100%;
            min-height: 200px;
        }

        .sortable-helper {
            transform: rotate(3deg);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 9999 !important;
        }

        /* Estilo para linha clamps */
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

        /* Botões de ação responsivos */
        @media (max-width: 640px) {
            .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
                grid-template-columns: 1fr;
            }
            
            .flex.items-center.justify-between > * {
                flex: 1;
                min-width: 0;
            }
            
            .flex.items-center.justify-between > form {
                margin: 0 2px;
            }
            
            .flex.items-center.justify-between > a,
            .flex.items-center.justify-between > form button {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            .flex.items-center.justify-between span.text-xs {
                display: none;
            }
            
            .flex.items-center.justify-between .mr-1 {
                margin-right: 0;
            }
        }

        /* Efeito hover nos botões */
        .inline-flex.items-center.justify-center.px-3.py-1\\.5 {
            transition: all 0.2s ease;
        }

        .inline-flex.items-center.justify-center.px-3.py-1\\.5:hover {
            transform: translateY(-1px);
        }

        /* Checkbox flutuante */
        .fixed.bottom-4.right-4 {
            z-index: 100;
        }

        /* Transições suaves */
        .transition-colors {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Tooltips */
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
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 5px;
        }

        /* Animações SweetAlert2 personalizadas */
        .swal2-popup {
            border-radius: 1rem !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
        }
    </style>
</x-app-layout>