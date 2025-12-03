<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Anúncio') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data" id="listing-form">
                @csrf

                <!-- Título -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Título *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Digite o título do anúncio" required>
                    @error('title') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Categoria -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Categoria</label>
                    <select name="category_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">-- Selecione uma categoria --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Descrição *</label>
                    <textarea name="description"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                              rows="5"
                              placeholder="Descreva detalhadamente o item ou serviço"
                              required>{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Preço</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">KZ</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                               placeholder="0,00">
                    </div>
                    @error('price') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Localização -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Localização</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Município, Bairro">
                    @error('location') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Informações de Contacto -->
                <div class="mb-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações de Contato</h3>

                    <!-- Telefone -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Telefone *</label>
                        <div class="flex items-center">
                            <i class="bi bi-telephone text-gray-500 mr-2"></i>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="(+244) 9XX XXX-XXX" required>
                        </div>
                        @error('phone') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="bi bi-whatsapp text-green-600 mr-1"></i> WhatsApp
                        </label>
                        <div class="flex items-center">
                            <i class="bi bi-whatsapp text-green-500 mr-2"></i>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   placeholder="(+244) 9XX XXX-XXX (se for diferente do telefone)">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Caso seja diferente do telefone principal. Deixe em branco se for o mesmo.
                        </p>
                        @error('whatsapp') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <div class="flex items-center">
                            <i class="bi bi-envelope text-gray-500 mr-2"></i>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="seu@email.com">
                        </div>
                        @error('email') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Imagens -->
                <div class="mb-6 border-t pt-6">
                    <label class="block text-gray-700 font-medium mb-2">Imagens</label>
                    <div class="image-upload-container border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition relative">
                        <i class="bi bi-images text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600 mb-2">Clique para selecionar imagens ou arraste e solte</p>
                        <p class="text-sm text-gray-500 mb-4">Formatos: JPG, PNG. Tamanho máximo: 4MB cada</p>
                        <input type="file" name="images[]" multiple
                               class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer"
                               accept="image/*"
                               id="image-upload">
                    </div>
                    <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    @error('images.*') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="active" @selected(old('status') == 'active')>Ativo</option>
                        <option value="pending" @selected(old('status') == 'pending')>Pendente</option>
                        <option value="sold" @selected(old('status') == 'sold')>Vendido</option>
                        <option value="expired" @selected(old('status') == 'expired')>Expirado</option>
                    </select>
                    @error('status') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Botões -->
                <div class="flex justify-between items-center pt-6 border-t">
                    <a href="{{ route('admin.ads.index') }}"
                       class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition">
                        <i class="bi bi-plus-circle mr-2"></i>Criar Anúncio
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- Script para preview de imagens e validações com SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================
            // PREVIEW DE IMAGENS
            // ============================================
            const fileInput = document.getElementById('image-upload');
            const previewContainer = document.getElementById('image-preview');

            if (fileInput && previewContainer) {
                fileInput.addEventListener('change', function() {
                    previewContainer.innerHTML = '';

                    if (this.files.length > 0) {
                        const maxFiles = 10;
                        const maxSize = 4 * 1024 * 1024; // 4MB
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                        let validFiles = [];
                        let errorMessages = [];

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
                                div.className = 'relative group';
                                div.setAttribute('data-file-index', index);

                                div.innerHTML = `
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                        <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview ${file.name}">
                                    </div>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer"
                                         onclick="removeImagePreview(this, ${index})"
                                         title="Remover imagem">
                                        <i class="bi bi-x text-sm"></i>
                                    </div>
                                    <div class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                        #${index + 1}
                                    </div>
                                `;

                                previewContainer.appendChild(div);
                            };

                            reader.readAsDataURL(file);
                        });

                        // Atualizar o input de arquivo com apenas os arquivos válidos
                        if (validFiles.length !== this.files.length) {
                            const dataTransfer = new DataTransfer();
                            validFiles.forEach(file => dataTransfer.items.add(file));
                            fileInput.files = dataTransfer.files;
                        }
                    }
                });
            }

            // ============================================
            // FORMATAÇÃO DE TELEFONE PARA ANGOLA
            // ============================================
            const phoneInput = document.querySelector('input[name="phone"]');
            const whatsappInput = document.querySelector('input[name="whatsapp"]');

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

            if (phoneInput) setupPhoneFormatting(phoneInput);
            if (whatsappInput) setupPhoneFormatting(whatsappInput);

            // ============================================
            // VALIDAÇÃO DO FORMULÁRIO COM SWEETALERT2
            // ============================================
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

                    // Validar imagens
                    const images = formData.getAll('images[]');
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

                    // Se tudo estiver válido, confirmar envio com SweetAlert2
                    window.confirmAction({
                        title: 'Criar Anúncio',
                        text: 'Tem certeza que deseja criar este anúncio?',
                        icon: 'question',
                        confirmButtonText: 'Sim, criar anúncio',
                        cancelButtonText: 'Revisar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar loading
                            window.showLoading('Criando anúncio...');

                            // Enviar formulário
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        }
                    });
                });
            }

            // ============================================
            // VALIDAÇÃO EM TEMPO REAL
            // ============================================

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
                updateCounter();
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

            // Validação em tempo real do preço
            const priceInput = document.querySelector('input[name="price"]');
            if (priceInput) {
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
        });

        // ============================================
        // FUNÇÃO PARA REMOVER IMAGEM DO PREVIEW
        // ============================================
        function removeImagePreview(element, fileIndex) {
            window.confirmDelete({
                title: 'Remover Imagem',
                text: 'Tem certeza que deseja remover esta imagem do preview?',
                icon: 'warning',
                confirmButtonText: 'Sim, remover'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remover elemento do DOM
                    const previewDiv = element.closest('.relative.group');
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
                            const previews = document.querySelectorAll('#image-preview .relative.group');
                            previews.forEach((preview, newIndex) => {
                                const indexBadge = preview.querySelector('.absolute.bottom-2');
                                if (indexBadge) {
                                    indexBadge.textContent = `#${newIndex + 1}`;
                                }
                                preview.setAttribute('data-file-index', newIndex);

                                // Atualizar onclick do botão de remover
                                const removeBtn = preview.querySelector('.absolute.top-2.right-2');
                                if (removeBtn) {
                                    removeBtn.setAttribute('onclick', `removeImagePreview(this, ${newIndex})`);
                                }
                            });
                        }, 300);
                    }
                }
            });
        }

        // ============================================
        // DRAG AND DROP PARA IMAGENS
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.querySelector('.image-upload-container');

            if (dropArea) {
                // Prevenir comportamentos padrão
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // Efeitos de highlight
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });

                function highlight() {
                    dropArea.classList.add('border-blue-500', 'bg-blue-50');
                    dropArea.style.borderWidth = '3px';
                }

                function unhighlight() {
                    dropArea.classList.remove('border-blue-500', 'bg-blue-50');
                    dropArea.style.borderWidth = '2px';
                }

                // Processar arquivos dropados
                dropArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    if (files.length > 0) {
                        const fileInput = document.getElementById('image-upload');

                        // Combinar arquivos existentes com novos
                        const existingFiles = Array.from(fileInput.files);
                        const newFiles = Array.from(files);
                        const allFiles = [...existingFiles, ...newFiles].slice(0, 10); // Limitar a 10 arquivos

                        // Criar DataTransfer com todos os arquivos
                        const dataTransfer = new DataTransfer();
                        allFiles.forEach(file => dataTransfer.items.add(file));
                        fileInput.files = dataTransfer.files;

                        // Disparar evento change
                        const event = new Event('change');
                        fileInput.dispatchEvent(event);

                        // Mostrar mensagem de sucesso
                        const addedCount = Math.min(newFiles.length, 10 - existingFiles.length);
                        if (addedCount > 0) {
                            window.showSuccess(`${addedCount} imagem(ns) adicionada(s) com sucesso!`);
                        }

                        if (newFiles.length > addedCount) {
                            window.showWarning(`Apenas ${addedCount} imagens foram adicionadas (limite de 10 atingido).`);
                        }
                    }

                    unhighlight();
                }
            }
        });
    </script>

    <!-- Estilos adicionais -->
    <style>
        /* Container para upload de imagens */
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

        /* Input de arquivo */
        #image-upload {
            z-index: 10;
        }

        /* Efeito hover */
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

        .border-2 {
            border-width: 2px;
        }

        .border-dashed {
            border-style: dashed;
        }

        .aspect-square {
            aspect-ratio: 1 / 1;
        }

        /* Estilo para campos obrigatórios */
        [required] + label::after {
            content: " *";
            color: #ef4444;
        }

        /* Melhor visualização dos campos de telefone */
        input[name="phone"],
        input[name="whatsapp"] {
            font-family: 'SF Mono', Monaco, 'Courier New', monospace;
            letter-spacing: 0.5px;
        }

        /* Estilos para preview de imagens */
        #image-preview .relative.group {
            transition: all 0.3s ease;
        }

        #image-preview .relative.group:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsividade para mobile */
        @media (max-width: 640px) {
            .image-upload-container {
                min-height: 120px;
                padding: 1rem;
            }

            #image-preview {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .aspect-square {
                aspect-ratio: 1 / 1;
            }

            input, textarea, select {
                padding: 0.75rem !important;
                font-size: 16px; /* Evita zoom em iOS */
            }
        }

        @media (max-width: 768px) {
            .flex.justify-between.items-center {
                flex-direction: column;
                gap: 1rem;
            }

            .flex.justify-between.items-center a,
            .flex.justify-between.items-center button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</x-app-layout>
