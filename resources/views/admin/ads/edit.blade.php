<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Anúncio') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <!-- Mensagens dinâmicas AJAX -->
            <div id="ajaxMessage" class="hidden mb-4 p-3 rounded"></div>

            <!-- Mensagens da sessão -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulário principal para editar o anúncio -->
            <form action="{{ route('admin.ads.update', $listing) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Título -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Título *</label>
                    <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           placeholder="Ex: iPhone 12 Pro Max 256GB">
                    @error('title')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Categoria -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Categoria *</label>
                    <select name="category_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">-- Selecione uma categoria --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $listing->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Descrição *</label>
                    <textarea name="description" rows="6"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              required
                              placeholder="Descreva o seu produto ou serviço de forma detalhada...">{{ old('description', $listing->description) }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preço -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Preço (€)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">€</span>
                        </div>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $listing->price) }}"
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0.00">
                    </div>
                    @error('price')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Condição (Novo/Usado) -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Condição</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="condition" value="new"
                                   class="h-5 w-5 text-blue-600"
                                   @checked(old('condition', $listing->condition ?? 'new') == 'new')>
                            <span class="ml-2 text-gray-700">Novo</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="condition" value="used"
                                   class="h-5 w-5 text-blue-600"
                                   @checked(old('condition', $listing->condition ?? 'new') == 'used')>
                            <span class="ml-2 text-gray-700">Usado</span>
                        </label>
                    </div>
                    @error('condition')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Localização -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Localização</label>
                    <input type="text" name="location" value="{{ old('location', $listing->location) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: Lisboa, Porto, Faro">
                    @error('location')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Telefone -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Telefone de contacto</label>
                    <input type="text" name="phone" value="{{ old('phone', $listing->phone) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: +351 912 345 678">
                    @error('phone')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email (opcional) -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Email (opcional)</label>
                    <input type="email" name="email" value="{{ old('email', $listing->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="seu@email.com">
                    @error('email')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status (Ativo/Inativo) -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="active" @selected(old('status', $listing->status) == 'active')>Ativo</option>
                        <option value="inactive" @selected(old('status', $listing->status) == 'inactive')>Inativo</option>
                        <option value="sold" @selected(old('status', $listing->status) == 'sold')>Vendido</option>
                        <option value="expired" @selected(old('status', $listing->status) == 'expired')>Expirado</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IMAGENS ATUAIS - ATUALIZADO -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-gray-700 font-medium">Imagens atuais</label>
                        <span class="text-sm text-gray-500">Clique no ✕ para remover</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="imagesContainer">
                        @forelse($listing->images as $image)
                            <div class="relative group border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300"
                                 id="image-{{ $image->id }}">
                                <img src="{{ asset('storage/'.$image->path) }}"
                                     alt="Imagem do anúncio"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                                <!-- BOTÃO COM AJAX -->
                                <button type="button"
                                        onclick="window.deleteImageAjax && window.deleteImageAjax({{ $image->id }})"
                                        class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm transition duration-200 shadow-lg transform hover:scale-110"
                                        title="Remover imagem">
                                    ✕
                                </button>

                                <!-- Índice da imagem -->
                                <div class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    #{{ $loop->iteration }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full p-8 text-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-gray-500">Nenhuma imagem enviada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Adicionar novas imagens -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-3">Adicionar novas imagens</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition duration-200 cursor-pointer"
                         onclick="document.getElementById('newImages').click()"
                         id="dropArea">
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="hidden"
                               id="newImages">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="text-blue-600 hover:text-blue-800 font-medium">Clique para selecionar</span> ou arraste e solte
                        </p>
                        <p class="text-gray-500 text-xs mt-1">PNG, JPG, GIF até 4MB cada</p>
                        @error('images.*')
                            <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Preview das novas imagens selecionadas -->
                    <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4 hidden"></div>
                </div>

                <!-- Botões de ação -->
                <div class="flex flex-wrap gap-3 pt-6 border-t">
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Anúncio
                    </button>

                    <a href="{{ route('admin.ads.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>

                    <!-- Botão para visualizar (rota public.show) -->
                    @if($listing->slug)
                    <a href="{{ route('public.show', $listing->slug) }}"
                       target="_blank"
                       class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Visualizar
                    </a>
                    @endif

                    <!-- Botão eliminar anúncio -->
                    <button type="button"
                            onclick="confirmDelete()"
                            class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 flex items-center ml-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar Anúncio
                    </button>
                </div>
            </form>

            <!-- Formulário oculto para eliminar anúncio -->
            <form id="deleteForm" action="{{ route('admin.ads.destroy', $listing) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>

    <!-- SCRIPT COMPLETO -->
    <script>
        // ============================================
        // FUNÇÕES GLOBAIS
        // ============================================

        // 1. Função para deletar imagem via AJAX
        window.deleteImageAjax = function(imageId) {
            if (!confirm('Tem certeza que deseja remover esta imagem?\nEsta ação não pode ser desfeita.')) {
                return false;
            }

            console.log('🖼️ Deletando imagem ID:', imageId);

            // Token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";

            // Elementos DOM
            const imageDiv = document.getElementById('image-' + imageId);
            const imageContainer = document.getElementById('imagesContainer');

            if (!imageDiv) {
                showMessage('error', 'Erro: Imagem não encontrada!');
                return false;
            }

            // Salvar conteúdo original para fallback
            const originalContent = imageDiv.innerHTML;

            // Mostrar loading
            imageDiv.innerHTML = `
                <div class="flex flex-col items-center justify-center h-48 bg-gray-100">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-2"></div>
                    <span class="text-gray-600 text-sm">Removendo...</span>
                </div>
            `;
            imageDiv.classList.add('opacity-50');

            // URL da rota AJAX - IMPORTANTE: deve ser admin.ajax.delete.image
            const url = "{{ route('admin.ajax.delete.image', ':id') }}".replace(':id', imageId);
            console.log('🌐 URL:', url);

            // Fazer requisição AJAX
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('📊 Status:', response.status);

                // Verificar se é JSON
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // Se não for JSON, recarregar a página
                    window.location.reload();
                    throw new Error('Resposta não é JSON');
                }
            })
            .then(data => {
                console.log('📦 Resposta:', data);

                if (data.success) {
                    // Animação de remoção
                    imageDiv.style.transition = 'all 0.3s ease';
                    imageDiv.style.opacity = '0';
                    imageDiv.style.transform = 'scale(0.8)';

                    setTimeout(() => {
                        imageDiv.remove();

                        // Mensagem de sucesso
                        showMessage('success', '✅ ' + (data.message || 'Imagem removida com sucesso!'));

                        // Se não houver mais imagens
                        if (imageContainer && imageContainer.children.length === 0) {
                            imageContainer.innerHTML = `
                                <div class="col-span-full p-8 text-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-gray-500">Nenhuma imagem enviada.</p>
                                </div>
                            `;
                        }
                    }, 300);

                } else {
                    // Erro do servidor
                    imageDiv.innerHTML = originalContent;
                    imageDiv.classList.remove('opacity-50');
                    showMessage('error', '❌ ' + (data.message || 'Erro ao remover imagem'));
                }
            })
            .catch(error => {
                console.error('🚨 Erro:', error);

                // Restaurar em caso de erro
                imageDiv.innerHTML = originalContent;
                imageDiv.classList.remove('opacity-50');

                showMessage('error', '❌ Erro: ' + error.message);
            });

            return false;
        };

        // 2. Função para mostrar mensagens
        window.showMessage = function(type, text) {
            // Remover mensagens anteriores
            const ajaxMessage = document.getElementById('ajaxMessage');
            if (ajaxMessage) {
                ajaxMessage.innerHTML = '';
                ajaxMessage.className = `mb-4 p-4 rounded-lg border ${
                    type === 'success'
                        ? 'bg-green-50 text-green-800 border-green-200'
                        : 'bg-red-50 text-red-800 border-red-200'
                }`;
                ajaxMessage.innerHTML = `
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            ${type === 'success' ? '✅' : '❌'}
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium">${text}</p>
                        </div>
                        <button type="button" onclick="this.parentElement.parentElement.classList.add('hidden')"
                                class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 justify-center items-center hover:bg-gray-100">
                            <span class="sr-only">Fechar</span>
                            ✕
                        </button>
                    </div>
                `;
                ajaxMessage.classList.remove('hidden');
            }

            // Auto-remover após 5 segundos
            setTimeout(() => {
                if (ajaxMessage) {
                    ajaxMessage.classList.add('hidden');
                }
            }, 5000);
        };

        // 3. Função para confirmar eliminação do anúncio
        window.confirmDelete = function() {
            if (confirm('⚠️ ATENÇÃO!\n\nTem certeza que deseja eliminar este anúncio PERMANENTEMENTE?\n\nEsta ação não pode ser desfeita e eliminará todas as imagens associadas.')) {
                document.getElementById('deleteForm').submit();
            }
        };

        // ============================================
        // PREVIEW DE IMAGENS NOVAS
        // ============================================
        const newImagesInput = document.getElementById('newImages');
        const dropArea = document.getElementById('dropArea');
        const imagePreview = document.getElementById('imagePreview');

        if (newImagesInput && dropArea && imagePreview) {
            // Click no drop area
            dropArea.addEventListener('click', (e) => {
                if (e.target.type !== 'file') {
                    newImagesInput.click();
                }
            });

            // Change no input file
            newImagesInput.addEventListener('change', function() {
                imagePreview.innerHTML = '';

                if (this.files.length > 0) {
                    imagePreview.classList.remove('hidden');

                    // Limitar a 10 imagens
                    const files = Array.from(this.files).slice(0, 10);

                    files.forEach((file, index) => {
                        if (!file.type.match('image.*')) return;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative border rounded-lg overflow-hidden shadow-sm';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-40 object-cover">
                                <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                    Nova #${index + 1}
                                </div>
                                <div class="p-2 bg-gray-50 text-xs text-gray-600 truncate border-t">
                                    ${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}
                                </div>
                            `;
                            imagePreview.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    });

                    // Aviso se houver mais de 10 imagens
                    if (this.files.length > 10) {
                        const warning = document.createElement('div');
                        warning.className = 'col-span-full p-3 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200 text-sm';
                        warning.textContent = `⚠️ Apenas as primeiras 10 imagens serão carregadas (${this.files.length} selecionadas)`;
                        imagePreview.appendChild(warning);
                    }
                } else {
                    imagePreview.classList.add('hidden');
                }
            });

            // Drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50', 'border-2');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50', 'border-2');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                newImagesInput.files = files;

                // Disparar evento change
                const event = new Event('change');
                newImagesInput.dispatchEvent(event);

                highlight(); // Mançar highlight por um momento
                setTimeout(unhighlight, 500);
            }
        }

        // ============================================
        // VALIDAÇÕES ADICIONAIS
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            // Validação do preço para aceitar apenas números
            const priceInput = document.querySelector('input[name="price"]');
            if (priceInput) {
                priceInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9.,]/g, '');
                });
            }

            // Validação do telefone
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
                });
            }

            // Contador de caracteres para descrição
            const descriptionTextarea = document.querySelector('textarea[name="description"]');
            if (descriptionTextarea) {
                const counter = document.createElement('div');
                counter.className = 'text-right text-xs text-gray-500 mt-1';
                counter.id = 'charCounter';
                descriptionTextarea.parentNode.appendChild(counter);

                function updateCounter() {
                    const length = descriptionTextarea.value.length;
                    counter.textContent = `${length} caracteres (mínimo: 10)`;
                    counter.className = `text-right text-xs mt-1 ${length < 10 ? 'text-red-500' : 'text-gray-500'}`;
                }

                descriptionTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Inicial
            }
        });

        // ============================================
        // DEBUG NO CONSOLE
        // ============================================
        console.log('✅ Script carregado com sucesso!');
        console.log('🔄 Função deleteImageAjax:', typeof window.deleteImageAjax);
        console.log('💬 Função showMessage:', typeof window.showMessage);
        console.log('🗑️ Função confirmDelete:', typeof window.confirmDelete);
        console.log('🔗 Rota AJAX de exemplo:', "{{ route('admin.ajax.delete.image', 999) }}");

        // Verificar se há imagens
        const imagesCount = document.querySelectorAll('[id^="image-"]').length;
        console.log(`🖼️ ${imagesCount} imagens encontradas na página`);
    </script>
</x-app-layout>
