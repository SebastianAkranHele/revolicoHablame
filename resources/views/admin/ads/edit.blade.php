<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Anúncio') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <!-- Formulário principal para editar o anúncio -->
            <form action="{{ route('admin.ads.update', $listing) }}" method="POST" enctype="multipart/form-data" id="listing-form">
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
                    <label class="block text-gray-700 font-medium mb-2">Preço (KZ)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">KZ</span>
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
                           placeholder="Ex: Luanda, Talatona, Belas">
                    @error('location')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Informações de Contacto -->
                <div class="mb-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações de Contato</h3>

                    <!-- Telefone -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Telefone *</label>
                        <div class="flex items-center">
                            <i class="bi bi-telephone text-gray-500 mr-2"></i>
                            <input type="text" name="phone" value="{{ old('phone', $listing->phone) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="(+244) 9XX XXX-XXX" required>
                        </div>
                        @error('phone')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-whatsapp text-green-600 mr-1"></i> WhatsApp
                        </label>
                        <div class="flex items-center">
                            <i class="bi bi-whatsapp text-green-500 mr-2"></i>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $listing->whatsapp) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="(+244) 9XX XXX-XXX (se for diferente do telefone)">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Caso seja diferente do telefone principal. Deixe em branco se for o mesmo.
                        </p>
                        @error('whatsapp')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email (opcional) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Email (opcional)</label>
                        <div class="flex items-center">
                            <i class="bi bi-envelope text-gray-500 mr-2"></i>
                            <input type="email" name="email" value="{{ old('email', $listing->email) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="seu@email.com">
                        </div>
                        @error('email')
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Status (Ativo/Inativo) -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="active" @selected(old('status', $listing->status) == 'active')>Ativo</option>
                        <option value="pending" @selected(old('status', $listing->status) == 'pending')>Pendente</option>
                        <option value="sold" @selected(old('status', $listing->status) == 'sold')>Vendido</option>
                        <option value="expired" @selected(old('status', $listing->status) == 'expired')>Expirado</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IMAGENS ATUAIS - ATUALIZADO COM SWEETALERT2 -->
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

                                <!-- BOTÃO COM AJAX E SWEETALERT2 -->
                                <button type="button"
                                        onclick="deleteImageAjaxWithSweetAlert({{ $image->id }})"
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
                                <i class="bi bi-images text-4xl text-gray-400 mb-3"></i>
                                <p class="mt-2 text-gray-500">Nenhuma imagem enviada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Adicionar novas imagens -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-3">Adicionar novas imagens</label>
                    <div class="image-upload-container border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition duration-200 cursor-pointer relative"
                         onclick="document.getElementById('image-upload').click()"
                         id="dropArea">
                        <i class="bi bi-images text-4xl text-gray-400 mb-3"></i>
                        <p class="text-sm text-gray-600 mt-2">
                            <span class="text-blue-600 hover:text-blue-800 font-medium">Clique para selecionar</span> ou arraste e solte
                        </p>
                        <p class="text-gray-500 text-xs mt-1">PNG, JPG até 4MB cada (Máximo: 10 imagens)</p>
                        <input type="file" name="images[]" multiple
                               class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer"
                               accept="image/*"
                               id="image-upload">
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
                        <i class="bi bi-check-circle mr-2"></i>
                        Actualizar Anúncio
                    </button>

                    <a href="{{ route('admin.ads.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <i class="bi bi-x-circle mr-2"></i>
                        Cancelar
                    </a>

                    <!-- Botão para visualizar (rota public.show) -->
                    @if($listing->slug)
                    <a href="{{ route('public.show', $listing->slug) }}"
                       target="_blank"
                       class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <i class="bi bi-eye mr-2"></i>
                        Visualizar
                    </a>
                    @endif

                    <!-- Botão eliminar anúncio -->
                    <button type="button"
                            onclick="confirmDeleteListing()"
                            class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 flex items-center ml-auto">
                        <i class="bi bi-trash mr-2"></i>
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

    <!-- SCRIPT COMPLETO COM SWEETALERT2 -->
    <script>
        // ============================================
        // FUNÇÕES GLOBAIS COM SWEETALERT2
        // ============================================

        // 1. Função para deletar imagem via AJAX com SweetAlert2
        window.deleteImageAjaxWithSweetAlert = function(imageId) {
            window.confirmDelete({
                title: 'Remover Imagem',
                text: 'Tem certeza que deseja remover esta imagem?\nEsta ação não pode ser desfeita.',
                icon: 'warning',
                confirmButtonText: 'Sim, remover!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('🖼️ Deletando imagem ID:', imageId);

                    // Token CSRF
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";

                    // Elementos DOM
                    const imageDiv = document.getElementById('image-' + imageId);
                    const imageContainer = document.getElementById('imagesContainer');

                    if (!imageDiv) {
                        window.showError('Erro: Imagem não encontrada!');
                        return false;
                    }

                    // Salvar conteúdo original para fallback
                    const originalContent = imageDiv.innerHTML;

                    // Mostrar loading no botão
                    imageDiv.innerHTML = `
                        <div class="flex flex-col items-center justify-center h-48 bg-gray-100">
                            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-2"></div>
                            <span class="text-gray-600 text-sm">Removendo...</span>
                        </div>
                    `;
                    imageDiv.classList.add('opacity-50');

                    // URL da rota AJAX
                    const url = "{{ route('admin.ajax.delete.image', ':id') }}".replace(':id', imageId);

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

                                // Mensagem de sucesso com SweetAlert2
                                window.showSuccess(data.message || 'Imagem removida com sucesso!');

                                // Se não houver mais imagens
                                if (imageContainer && imageContainer.children.length === 0) {
                                    imageContainer.innerHTML = `
                                        <div class="col-span-full p-8 text-center border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                            <i class="bi bi-images text-4xl text-gray-400 mb-3"></i>
                                            <p class="mt-2 text-gray-500">Nenhuma imagem enviada.</p>
                                        </div>
                                    `;
                                }
                            }, 300);

                        } else {
                            // Erro do servidor
                            imageDiv.innerHTML = originalContent;
                            imageDiv.classList.remove('opacity-50');
                            window.showError(data.message || 'Erro ao remover imagem');
                        }
                    })
                    .catch(error => {
                        console.error('🚨 Erro:', error);

                        // Restaurar em caso de erro
                        imageDiv.innerHTML = originalContent;
                        imageDiv.classList.remove('opacity-50');

                        window.showError('Erro: ' + error.message);
                    });
                }
            });
        };

        // 2. Função para confirmar eliminação do anúncio com SweetAlert2
        window.confirmDeleteListing = function() {
            window.confirmDelete({
                title: 'Eliminar Anúncio',
                text: 'Esta ação eliminará PERMANENTEMENTE o anúncio e todas as suas imagens!\n\nEsta ação não pode ser desfeita.',
                icon: 'error',
                confirmButtonText: 'Sim, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        };

        // 3. Validação do formulário com SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('listing-form');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Coletar dados do formulário
                    const formData = new FormData(this);
                    const title = formData.get('title')?.toString().trim() || '';
                    const description = formData.get('description')?.toString().trim() || '';
                    const phone = formData.get('phone')?.toString().trim() || '';
                    const categoryId = formData.get('category_id')?.toString() || '';

                    // Validar campos obrigatórios
                    const errors = [];

                    if (!title) {
                        errors.push('• O título é obrigatório');
                    } else if (title.length < 5) {
                        errors.push('• O título deve ter pelo menos 5 caracteres');
                    }

                    if (!categoryId) {
                        errors.push('• A categoria é obrigatória');
                    }

                    if (!description) {
                        errors.push('• A descrição é obrigatória');
                    } else if (description.length < 10) {
                        errors.push('• A descrição deve ter pelo menos 10 caracteres');
                    }

                    if (!phone) {
                        errors.push('• O telefone é obrigatório');
                    } else {
                        // Validar formato do telefone de Angola
                        const cleanPhone = phone.replace(/\D/g, '');
                        if (!cleanPhone.match(/^(244)?9[0-9]{8}$/) && !cleanPhone.match(/^[2-9][0-9]{7,8}$/)) {
                            errors.push('• Telefone inválido. Use o formato angolano: (+244) 9XX XXX XXX');
                        }
                    }

                    // Validar imagens novas
                    const images = formData.getAll('images[]');
                    const maxTotalImages = 10;
                    const currentImagesCount = document.querySelectorAll('#imagesContainer [id^="image-"]').length;
                    const totalImagesCount = currentImagesCount + images.length;

                    if (totalImagesCount > maxTotalImages) {
                        errors.push(`• Limite de ${maxTotalImages} imagens excedido. Você tem ${currentImagesCount} imagens atuais e está tentando adicionar mais ${images.length}.`);
                    }

                    if (images.length > 0) {
                        images.forEach((image, index) => {
                            if (image instanceof File) {
                                if (image.size > 4 * 1024 * 1024) {
                                    errors.push(`• A imagem "${image.name}" excede 4MB`);
                                }
                                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(image.type)) {
                                    errors.push(`• A imagem "${image.name}" não é JPG ou PNG`);
                                }
                            }
                        });
                    }

                    // Se houver erros, mostrar com SweetAlert2
                    if (errors.length > 0) {
                        window.showModalError(
                            `<div class="text-left space-y-1 max-h-60 overflow-y-auto">` +
                            errors.map(error => `<p class="text-red-600">${error}</p>`).join('') +
                            `</div>`,
                            'Formulário Incompleto'
                        ).then(() => {
                            // Focar no primeiro campo com erro
                            const firstError = errors[0];
                            if (firstError.includes('título')) {
                                document.querySelector('input[name="title"]').focus();
                            } else if (firstError.includes('categoria')) {
                                document.querySelector('select[name="category_id"]').focus();
                            } else if (firstError.includes('descrição')) {
                                document.querySelector('textarea[name="description"]').focus();
                            } else if (firstError.includes('telefone')) {
                                document.querySelector('input[name="phone"]').focus();
                            } else if (firstError.includes('imagem')) {
                                document.getElementById('image-upload').focus();
                            }
                        });

                        return false;
                    }

                    // Se tudo estiver válido, confirmar atualização com SweetAlert2
                    window.confirmAction({
                        title: 'Atualizar Anúncio',
                        text: 'Tem certeza que deseja salvar as alterações neste anúncio?',
                        icon: 'question',
                        confirmButtonText: 'Sim, atualizar',
                        cancelButtonText: 'Revisar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar loading
                            window.showLoading('Atualizando anúncio...');

                            // Enviar formulário
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        }
                    });
                });
            }

            // ============================================
            // PREVIEW DE IMAGENS NOVAS COM VALIDAÇÃO
            // ============================================
            const fileInput = document.getElementById('image-upload');
            const dropArea = document.getElementById('dropArea');
            const imagePreview = document.getElementById('imagePreview');

            if (fileInput && dropArea && imagePreview) {
                // Click no drop area
                dropArea.addEventListener('click', (e) => {
                    if (e.target.type !== 'file') {
                        fileInput.click();
                    }
                });

                // Change no input file
                fileInput.addEventListener('change', function() {
                    imagePreview.innerHTML = '';

                    if (this.files.length > 0) {
                        imagePreview.classList.remove('hidden');

                        // Validar arquivos
                        const maxFiles = 10;
                        const maxSize = 4 * 1024 * 1024; // 4MB
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                        let validFiles = [];
                        let errorMessages = [];
                        let currentImagesCount = document.querySelectorAll('#imagesContainer [id^="image-"]').length;

                        // Validar arquivos
                        Array.from(this.files).forEach((file, index) => {
                            if (index >= maxFiles) {
                                errorMessages.push(`Apenas os primeiros ${maxFiles} arquivos serão processados.`);
                                return;
                            }

                            if (!allowedTypes.includes(file.type)) {
                                errorMessages.push(`"${file.name}" não é um tipo de imagem válido (apenas JPG, PNG).`);
                                return;
                            }

                            if (file.size > maxSize) {
                                errorMessages.push(`"${file.name}" excede o limite de 4MB.`);
                                return;
                            }

                            if (currentImagesCount + validFiles.length >= maxFiles) {
                                errorMessages.push(`Limite de ${maxFiles} imagens atingido.`);
                                return;
                            }

                            validFiles.push(file);
                        });

                        // Mostrar erros se houver
                        if (errorMessages.length > 0) {
                            window.showWarning(
                                errorMessages.slice(0, 3).join('\n') +
                                (errorMessages.length > 3 ? '\n... e mais ' + (errorMessages.length - 3) + ' erros.' : ''),
                                'Atenção com as imagens'
                            );
                        }

                        // Mostrar preview das imagens válidas
                        validFiles.forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'relative border rounded-lg overflow-hidden shadow-sm';
                                div.setAttribute('data-file-index', index);

                                div.innerHTML = `
                                    <img src="${e.target.result}" class="w-full h-40 object-cover">
                                    <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                        Nova #${index + 1}
                                    </div>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-80 hover:opacity-100 transition cursor-pointer"
                                         onclick="removeNewImagePreview(this, ${index})"
                                         title="Remover imagem">
                                        <i class="bi bi-x text-sm"></i>
                                    </div>
                                    <div class="p-2 bg-gray-50 text-xs text-gray-600 truncate border-t">
                                        ${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}
                                        <div class="text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                                    </div>
                                `;
                                imagePreview.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        });

                        // Atualizar o input de arquivo com apenas os arquivos válidos
                        if (validFiles.length !== this.files.length) {
                            const dataTransfer = new DataTransfer();
                            validFiles.forEach(file => dataTransfer.items.add(file));
                            fileInput.files = dataTransfer.files;
                        }

                        // Aviso se houver mais de 10 imagens
                        if (this.files.length > 10) {
                            window.showWarning(`Apenas as primeiras 10 imagens serão carregadas (${this.files.length} selecionadas)`);
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

                    // Criar DataTransfer para atualizar os arquivos
                    const dataTransfer = new DataTransfer();
                    for (let i = 0; i < files.length; i++) {
                        dataTransfer.items.add(files[i]);
                    }
                    fileInput.files = dataTransfer.files;

                    // Disparar evento change
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);

                    highlight();
                    setTimeout(unhighlight, 500);
                }
            }

            // ============================================
            // FORMATAÇÃO DE TELEFONE PARA ANGOLA
            // ============================================
            function formatAngolanPhone(value) {
                // Remove tudo que não é número
                let numbers = value.replace(/\D/g, '');

                // Para Angola, celulares geralmente têm 9 dígitos: 9XX XXX XXX

                // Verifica se começa com 244 (código do país)
                if (numbers.startsWith('244')) {
                    numbers = numbers.substring(3); // Remove '244'
                }

                // Se o número tiver 9 dígitos, formata como celular
                if (numbers.length === 9) {
                    // Verifica se começa com 9 (celulares em Angola começam com 9)
                    if (numbers.startsWith('9')) {
                        numbers = numbers.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3');
                        return '+244 ' + numbers;
                    }
                }

                // Se for número fixo ou diferente, formata de forma genérica
                if (numbers.length <= 3) {
                    return numbers;
                } else if (numbers.length <= 6) {
                    return numbers.replace(/(\d{3})(\d{0,3})/, '$1 $2');
                } else if (numbers.length <= 9) {
                    return numbers.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1 $2 $3');
                } else {
                    return numbers.replace(/(\d{3})(\d{3})(\d{3})(\d{0,4})/, '$1 $2 $3 $4');
                }
            }

            function setupPhoneFormatting(inputElement) {
                if (inputElement) {
                    inputElement.addEventListener('input', function(e) {
                        // Salva posição do cursor
                        const start = this.selectionStart;
                        const end = this.selectionEnd;

                        // Formata o número
                        this.value = formatAngolanPhone(this.value);

                        // Restaura posição do cursor
                        const addedSpaces = (this.value.slice(0, start).match(/ /g) || []).length;
                        const originalSpaces = (e.target.defaultValue?.slice(0, start).match(/ /g) || []).length;
                        const spaceDiff = addedSpaces - originalSpaces;
                        this.setSelectionRange(start + spaceDiff, end + spaceDiff);
                    });
                }
            }

            // ============================================
            // VALIDAÇÕES ADICIONAIS
            // ============================================
            // Formatação de telefone
            const phoneInput = document.querySelector('input[name="phone"]');
            const whatsappInput = document.querySelector('input[name="whatsapp"]');

            if (phoneInput) setupPhoneFormatting(phoneInput);
            if (whatsappInput) setupPhoneFormatting(whatsappInput);

            // Validação do preço para aceitar apenas números
            const priceInput = document.querySelector('input[name="price"]');
            if (priceInput) {
                priceInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9.,]/g, '');
                });

                // Validação em tempo real
                priceInput.addEventListener('blur', function() {
                    const value = parseFloat(this.value);
                    if (value < 0) {
                        window.showWarning('O preço não pode ser negativo', 'Preço Inválido');
                        this.value = '';
                    } else if (value > 1000000000) { // 1 bilhão
                        window.showWarning('O preço parece muito alto. Verifique o valor.', 'Preço Muito Alto');
                    }
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
                    counter.className = `text-right text-xs mt-1 ${length < 10 ? 'text-red-500 font-medium' : 'text-gray-500'}`;
                }

                descriptionTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Inicial
            }

            // Validação em tempo real do telefone
            if (phoneInput) {
                phoneInput.addEventListener('blur', function() {
                    const value = this.value.trim();
                    if (value) {
                        const cleanValue = value.replace(/\D/g, '');
                        if (!cleanValue.match(/^(244)?9[0-9]{8}$/) && !cleanValue.match(/^[2-9][0-9]{7,8}$/)) {
                            window.showWarning('Verifique o número de telefone. Formato esperado: (+244) 9XX XXX XXX', 'Telefone Inválido');
                        }
                    }
                });
            }
        });

        // ============================================
        // FUNÇÃO PARA REMOVER IMAGEM DO PREVIEW
        // ============================================
        window.removeNewImagePreview = function(element, fileIndex) {
            window.confirmDelete({
                title: 'Remover Imagem',
                text: 'Tem certeza que deseja remover esta imagem do preview?',
                icon: 'warning',
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remover elemento do DOM
                    const previewDiv = element.closest('.relative.border');
                    if (previewDiv) {
                        previewDiv.style.opacity = '0';
                        previewDiv.style.transform = 'scale(0.8)';

                        setTimeout(() => {
                            previewDiv.remove();

                            // Remover arquivo do input
                            const fileInput = document.getElementById('image-upload');
                            if (fileInput && fileInput.files.length > 0) {
                                const dataTransfer = new DataTransfer();
                                Array.from(fileInput.files).forEach((file, index) => {
                                    if (index !== fileIndex) {
                                        dataTransfer.items.add(file);
                                    }
                                });
                                fileInput.files = dataTransfer.files;

                                // Mostrar mensagem
                                window.showSuccess('Imagem removida do preview');
                            }

                            // Atualizar índices dos previews restantes
                            const previews = document.querySelectorAll('#imagePreview .relative.border');
                            previews.forEach((preview, newIndex) => {
                                const indexBadge = preview.querySelector('.absolute.top-2.left-2');
                                if (indexBadge) {
                                    indexBadge.textContent = `Nova #${newIndex + 1}`;
                                }
                                preview.setAttribute('data-file-index', newIndex);

                                // Atualizar onclick do botão de remover
                                const removeBtn = preview.querySelector('.absolute.top-2.right-2');
                                if (removeBtn) {
                                    removeBtn.setAttribute('onclick', `removeNewImagePreview(this, ${newIndex})`);
                                }
                            });

                            // Se não houver mais previews, esconder container
                            if (previews.length === 0) {
                                document.getElementById('imagePreview').classList.add('hidden');
                            }
                        }, 300);
                    }
                }
            });
        };

        // ============================================
        // ESTILOS PARA UPLOAD DE IMAGENS
        // ============================================
        const style = document.createElement('style');
        style.textContent = `
            .image-upload-container {
                position: relative;
                min-height: 150px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            #image-upload {
                z-index: 10;
            }

            .image-upload-container:hover {
                background-color: #f9fafb;
                border-color: #3b82f6;
            }

            /* Efeito drag over */
            .image-upload-container.dragover {
                background-color: #eff6ff;
                border-color: #2563eb;
                transform: scale(1.02);
            }

            /* Responsividade */
            @media (max-width: 640px) {
                .image-upload-container {
                    min-height: 120px;
                    padding: 1rem;
                }

                #imagesContainer,
                #imagePreview {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 0.5rem;
                }
            }

            @media (max-width: 768px) {
                .flex.flex-wrap.gap-3 {
                    flex-direction: column;
                }

                .flex.flex-wrap.gap-3 button,
                .flex.flex-wrap.gap-3 a {
                    width: 100%;
                    justify-content: center;
                }
            }
        `;
        document.head.appendChild(style);

        console.log('✅ SweetAlert2 configurado para edição de anúncio!');
    </script>
</x-app-layout>
