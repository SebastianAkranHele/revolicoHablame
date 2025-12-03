<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.categories.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Categoria</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $category->name }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $category->is_active ? 'Ativa' : 'Inativa' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl overflow-hidden">
                <!-- Cabeçalho do formulário -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Editar Categoria</h3>
                            <p class="text-sm text-gray-600">Atualize os dados da categoria</p>
                        </div>
                    </div>
                </div>

                <!-- Informações da categoria -->
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Criada em:</span>
                            <p class="font-medium">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Última atualização:</span>
                            <p class="font-medium">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Anúncios:</span>
                            <p class="font-medium">{{ $category->listings->count() }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Subcategorias:</span>
                            <p class="font-medium">{{ $category->children->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Mensagens de erro -->
                @if ($errors->any())
                    <div class="m-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Corrija os seguintes erros:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulário -->
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Linha 1: Nome e Slug -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nome da Categoria *
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $category->name) }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                       placeholder="Ex: Eletrônicos"
                                       required
                                       autofocus>
                                <p class="mt-1 text-xs text-gray-500">Nome que será exibido no site</p>
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                    Slug (URL)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <span class="text-sm">/categorias/</span>
                                    </div>
                                    <input type="text"
                                           name="slug"
                                           id="slug"
                                           value="{{ old('slug', $category->slug) }}"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pl-24"
                                           placeholder="eletronicos">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Identificador único na URL</p>
                            </div>
                        </div>

                        <!-- Linha 2: Categoria Pai e Ícone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Categoria Pai -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Categoria Pai
                                </label>
                                <select name="parent_id"
                                        id="parent_id"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">-- Sem categoria pai (principal) --</option>
                                    @foreach($categories as $cat)
                                        @if($cat->id !== $category->id)
                                            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                                @if($cat->icon)
                                                    ({{ $cat->icon }})
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($category->parent)
                                    <p class="mt-1 text-xs text-blue-600">
                                        Atualmente: <strong>{{ $category->parent->name }}</strong>
                                    </p>
                                @endif
                                <p class="mt-1 text-xs text-gray-500">Selecione se esta é uma subcategoria</p>
                            </div>

                            <!-- Ícone -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">
                                    Ícone
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <span class="text-sm">bi-</span>
                                    </div>
                                    <input type="text"
                                           name="icon"
                                           id="icon"
                                           value="{{ old('icon', $category->icon) }}"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pl-10"
                                           placeholder="box">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Ícone do Bootstrap Icons.
                                    <a href="https://icons.getbootstrap.com/" target="_blank" class="text-blue-600 hover:text-blue-800">Ver ícones disponíveis</a>
                                </p>

                                <!-- Exibição do ícone em tempo real -->
                                <div class="mt-3 flex items-center space-x-4">
                                    <div id="icon-preview" class="h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            @php
                                                $currentIcon = old('icon', $category->icon);
                                            @endphp
                                            @if($currentIcon === 'box')
                                                <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5z" clip-rule="evenodd"/>
                                            @elseif($currentIcon === 'tv')
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                            @elseif($currentIcon === 'phone')
                                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            @elseif($currentIcon === 'car-front')
                                                <path fill-rule="evenodd" d="M2.5 7.5A.5.5 0 013 7h10a.5.5 0 01.5.5v7a.5.5 0 01-.5.5H3a.5.5 0 01-.5-.5v-7zM4 8v6h8V8H4z"/>
                                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V5a1 1 0 00-1-1H4z"/>
                                            @elseif($currentIcon === 'house-door')
                                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                                            @else
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <span id="icon-name" class="text-sm text-gray-600 font-mono">{{ old('icon', $category->icon) }}</span>
                                        <p class="text-xs text-gray-500">Ícone atual</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Linha 3: Ordem e Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ordem -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                    Ordem de Exibição
                                </label>
                                <input type="number"
                                       name="order"
                                       id="order"
                                       value="{{ old('order', $category->order) }}"
                                       min="0"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <p class="mt-1 text-xs text-gray-500">Número para ordenar as categorias (menor aparece primeiro)</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_active" class="ml-2 text-sm text-gray-700">
                                            Categoria ativa (visível no site)
                                        </label>
                                    </div>
                                </div>
                                @if($category->children->count() > 0)
                                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                        <p class="text-xs text-yellow-800">
                                            ⚠️ Esta categoria possui <strong>{{ $category->children->count() }}</strong> subcategorias.
                                            Ao desativá-la, considere também as subcategorias.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Descrição
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                      placeholder="Descreva a categoria para melhor organização...">{{ old('description', $category->description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Descrição interna para organização (não visível publicamente)</p>
                        </div>

                        <!-- Sugestões de Ícones -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Sugestões de Ícones Populares
                            </label>
                            <div class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 gap-2">
                                @php
                                    $popularIcons = [
                                        'box', 'tv', 'phone', 'laptop', 'tablet', 'car-front',
                                        'house-door', 'building', 'tools', 'person', 'book',
                                        'shirt', 'cart', 'music-note', 'controller', 'cup',
                                        'heart', 'star', 'bag', 'cpu', 'palette', 'gift'
                                    ];
                                @endphp
                                @foreach($popularIcons as $icon)
                                    <button type="button"
                                            class="icon-suggestion p-2 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition flex flex-col items-center {{ $icon === old('icon', $category->icon) ? 'bg-blue-100 border-blue-400' : 'border-gray-300' }}"
                                            data-icon="{{ $icon }}">
                                        <svg class="w-5 h-5 text-gray-600 mb-1" fill="currentColor" viewBox="0 0 20 20">
                                            @if($icon === 'box')
                                                <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5z" clip-rule="evenodd"/>
                                            @elseif($icon === 'tv')
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                            @elseif($icon === 'phone')
                                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            @elseif($icon === 'car-front')
                                                <path fill-rule="evenodd" d="M2.5 7.5A.5.5 0 013 7h10a.5.5 0 01.5.5v7a.5.5 0 01-.5.5H3a.5.5 0 01-.5-.5v-7zM4 8v6h8V8H4z"/>
                                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V5a1 1 0 00-1-1H4z"/>
                                            @elseif($icon === 'house-door')
                                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                                            @else
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            @endif
                                        </svg>
                                        <span class="text-xs text-gray-500 truncate w-full text-center">{{ $icon }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé do formulário -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.categories.index') }}"
                               class="text-sm text-gray-600 hover:text-gray-900">
                                ← Voltar para lista
                            </a>
                            @if($category->children->count() == 0 && $category->listings->count() == 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Excluir categoria
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                               class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-medium shadow-sm">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Atualizar Categoria
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ações adicionais -->
            @if($category->children->count() > 0 || $category->listings->count() > 0)
                <div class="mt-6 bg-white shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b">
                        <h4 class="text-lg font-semibold text-gray-900">Avisos e Informações</h4>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($category->children->count() > 0)
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-yellow-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Esta categoria possui <strong>{{ $category->children->count() }}</strong> subcategorias.
                                        Para excluir esta categoria, primeiro exclua ou mova todas as subcategorias.
                                    </p>
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($category->children as $child)
                                            <a href="{{ route('admin.categories.edit', $child) }}"
                                               class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($category->listings->count() > 0)
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-yellow-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Esta categoria possui <strong>{{ $category->listings->count() }}</strong> anúncios.
                                        Para excluir esta categoria, primeiro mova ou exclua todos os anúncios.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from name (only if name changed and slug empty)
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const originalName = "{{ $category->name }}";

        nameInput.addEventListener('blur', function() {
            if (nameInput.value !== originalName && !slugInput.value) {
                generateSlug(nameInput.value);
            }
        });

        function generateSlug(text) {
            fetch('/admin/categories/generate-slug?text=' + encodeURIComponent(text))
                .then(response => response.json())
                .then(data => {
                    if (data.slug) {
                        slugInput.value = data.slug;
                    }
                })
                .catch(() => {
                    // Fallback: generate slug client-side
                    const slug = text
                        .toLowerCase()
                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)+/g, '');
                    slugInput.value = slug;
                });
        }

        // Icon preview and selection
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');
        const iconName = document.getElementById('icon-name');

        // Update icon preview when typing
        iconInput.addEventListener('input', function() {
            updateIconPreview(this.value);
        });

        // Icon suggestion buttons
        document.querySelectorAll('.icon-suggestion').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.getAttribute('data-icon');
                iconInput.value = icon;
                updateIconPreview(icon);

                // Update active state
                document.querySelectorAll('.icon-suggestion').forEach(btn => {
                    btn.classList.remove('bg-blue-100', 'border-blue-400');
                    btn.classList.add('border-gray-300');
                });
                this.classList.add('bg-blue-100', 'border-blue-400');
                this.classList.remove('border-gray-300');
            });
        });

        function updateIconPreview(iconNameValue) {
            if (!iconNameValue) return;

            // Update preview display
            iconName.textContent = iconNameValue;

            // Here you could dynamically change the SVG based on icon
            // For now, we just change the text
        }

        // Form submission validation
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            const name = nameInput.value.trim();
            if (!name) {
                e.preventDefault();
                nameInput.focus();
                showError(nameInput, 'Por favor, insira um nome para a categoria.');
                return;
            }

            // Validate parent category (can't be its own child)
            const parentId = document.getElementById('parent_id').value;
            const categoryId = "{{ $category->id }}";

            if (parentId === categoryId) {
                e.preventDefault();
                showError(document.getElementById('parent_id'), 'Uma categoria não pode ser pai de si mesma.');
                return;
            }

            // Clear any previous errors
            clearErrors();
        });

        function showError(element, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'mt-1 text-sm text-red-600';
            errorDiv.textContent = message;
            element.parentNode.appendChild(errorDiv);
            element.classList.add('border-red-500');
        }

        function clearErrors() {
            document.querySelectorAll('.text-red-600').forEach(el => el.remove());
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        }

        // Auto-focus on name field
        nameInput.focus();
        nameInput.select();
    });
    </script>
    @endpush

    @push('styles')
    <style>
        .icon-suggestion {
            transition: all 0.2s ease;
        }
        .icon-suggestion:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .icon-suggestion.active {
            background-color: #eff6ff;
            border-color: #3b82f6;
            color: #1d4ed8;
        }
    </style>
    @endpush
</x-app-layout>
