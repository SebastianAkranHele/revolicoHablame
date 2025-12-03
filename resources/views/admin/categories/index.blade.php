<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg border border-green-200 flex justify-between items-center" id="success-message">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('success-message').remove()" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-lg border border-red-200 flex justify-between items-center" id="error-message">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="document.getElementById('error-message').remove()" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Barra de ações superiores -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-medium text-gray-900">Gerenciamento de Categorias</h3>
                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                    {{ $categories->total() }} categorias
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.categories.export') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar CSV
                </a>
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Categoria
                </a>
            </div>
        </div>

        <!-- Barra de ações em massa (aparece quando itens são selecionados) -->
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

        <!-- Tabela de Categorias -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 50px;">
                                <div class="flex items-center">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ícone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hierarquia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anúncios</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="sortable" class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                            <tr data-id="{{ $category->id }}" class="hover:bg-gray-50 transition cursor-move sortable-item">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               value="{{ $category->id }}"
                                               class="select-item rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
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
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                                            @if($category->description)
                                                <div class="text-xs text-gray-400 mt-1 line-clamp-1">
                                                    {{ \Illuminate\Support\Str::limit($category->description, 50) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $category->icon }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($category->parent)
                                        <div class="flex items-center text-sm text-gray-900">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $category->parent->name }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Principal
                                        </span>
                                    @endif
                                    @if($category->children_count > 0)
                                        <div class="mt-1 text-xs text-gray-500">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                            {{ $category->children_count }} subcategorias
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ $category->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $listingsCount = $category->listings_count ?? $category->listings()->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $listingsCount > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $listingsCount }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
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
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="text-blue-600 hover:text-blue-900 transition"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.categories.duplicate', $category) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="text-yellow-600 hover:text-yellow-900 transition"
                                                    title="Duplicar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta categoria?')"
                                                    class="text-red-600 hover:text-red-900 transition"
                                                    title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <button type="button"
                                                class="text-gray-400 hover:text-gray-600 transition handle cursor-move"
                                                title="Arrastar para reordenar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">Nenhuma categoria encontrada</p>
                                        <p class="text-gray-500">Comece criando sua primeira categoria</p>
                                        <a href="{{ route('admin.categories.create') }}"
                                           class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            Criar Categoria
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação -->
        @if($categories->hasPages())
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        @endif

    </div>

    @push('styles')
    <style>
        .sortable-item {
            transition: background-color 0.2s ease;
        }
        .sortable-item:hover {
            background-color: #f9fafb;
        }
        .sortable-helper {
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 0.5rem;
            opacity: 0.9;
        }
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .handle:hover {
            cursor: grab;
        }
        .handle:active {
            cursor: grabbing;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
    $(document).ready(function() {
        // Controle de seleção
        let selectedItems = new Set();

        // Toggle select all
        $('#select-all').change(function() {
            const isChecked = this.checked;
            $('.select-item').prop('checked', isChecked);

            if (isChecked) {
                $('.select-item').each(function() {
                    selectedItems.add($(this).val());
                });
            } else {
                selectedItems.clear();
            }
            updateBulkActions();
        });

        // Toggle individual items
        $('.select-item').change(function() {
            const value = $(this).val();

            if (this.checked) {
                selectedItems.add(value);
            } else {
                selectedItems.delete(value);
                $('#select-all').prop('checked', false);
            }
            updateBulkActions();
        });

        // Update bulk actions bar
        function updateBulkActions() {
            const count = selectedItems.size;
            $('#selected-count').text(count);

            if (count > 0) {
                $('#bulk-actions').removeClass('hidden');
            } else {
                $('#bulk-actions').addClass('hidden');
            }
        }

        // Bulk actions
        $('#bulk-activate').click(function() {
            if (selectedItems.size === 0) return;
            bulkAction('{{ route("admin.categories.bulk-status") }}', {
                ids: Array.from(selectedItems),
                status: 1
            }, 'ativar');
        });

        $('#bulk-deactivate').click(function() {
            if (selectedItems.size === 0) return;
            bulkAction('{{ route("admin.categories.bulk-status") }}', {
                ids: Array.from(selectedItems),
                status: 0
            }, 'desativar');
        });

        $('#bulk-delete-btn').click(function() {
            if (selectedItems.size === 0) return;

            if (confirm(`Tem certeza que deseja excluir ${selectedItems.size} categoria(s)? Esta ação não pode ser desfeita.`)) {
                bulkAction('{{ route("admin.categories.bulk-delete") }}', {
                    ids: Array.from(selectedItems)
                }, 'excluir');
            }
        });

        // AJAX bulk action
        function bulkAction(url, data, action) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    ...data,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showAlert('error', 'Ocorreu um erro. Tente novamente.');
                    }
                },
                error: function(xhr) {
                    let message = 'Ocorreu um erro. Tente novamente.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).join('\n');
                    }
                    showAlert('error', message);
                }
            });
        }

        // Show alert
        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'green' : 'red';
            const alertDiv = `
                <div class="bg-${alertClass}-100 text-${alertClass}-800 p-4 rounded-lg border border-${alertClass}-200 flex justify-between items-center" id="ajax-alert">
                    <span>${message}</span>
                    <button type="button" onclick="document.getElementById('ajax-alert').remove()" class="text-${alertClass}-600 hover:text-${alertClass}-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

            $('.space-y-6').prepend(alertDiv);
            setTimeout(() => {
                $('#ajax-alert').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }

        // Sortable initialization
        $('#sortable').sortable({
            handle: '.handle, .sortable-item td:not(:first-child)',
            helper: function(e, ui) {
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                ui.addClass('sortable-helper');
                return ui;
            },
            start: function(e, ui) {
                ui.helper.css('z-index', 1000);
            },
            update: function(event, ui) {
                const ids = [];
                $('#sortable tr.sortable-item').each(function() {
                    ids.push($(this).data('id'));
                });

                $.ajax({
                    url: '{{ route("admin.categories.reorder") }}',
                    method: 'POST',
                    data: {
                        ids: ids,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', 'Ordem atualizada com sucesso!');
                        }
                    },
                    error: function() {
                        showAlert('error', 'Erro ao atualizar ordem.');
                    }
                });
            }
        });

        // Disable sortable on checkbox click
        $('.select-item, #select-all').click(function(e) {
            e.stopPropagation();
        });
    });
    </script>
    @endpush
</x-app-layout>
