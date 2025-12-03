<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Anúncio') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Título -->
                <div class="mb-4">
                    <label class="block text-gray-700">Título</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2" required>
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Categoria -->
                <div class="mb-4">
                    <label class="block text-gray-700">Categoria</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Selecione --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label class="block text-gray-700">Descrição</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <label class="block text-gray-700">Preço</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2">
                    @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Localização -->
                <div class="mb-4">
                    <label class="block text-gray-700">Localização</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Telefone -->
                <div class="mb-4">
                    <label class="block text-gray-700">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Imagens -->
                <div class="mb-4">
                    <label class="block text-gray-700">Imagens</label>
                    <input type="file" name="images[]" multiple class="w-full border rounded px-3 py-2">
                    @error('images.*') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Criar Anúncio</button>
            </form>

        </div>
    </div>
</x-app-layout>
