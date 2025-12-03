<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do Administrador') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total de Anúncios -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Anúncios</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $listingsCount }}</p>
                    <a href="{{ route('admin.ads.index') }}" class="text-sm text-blue-600 mt-4 hover:underline">Gerenciar
                        Anúncios →</a>
                </div>

                <!-- Total de Categorias -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Categorias</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $categoriesCount }}</p>
                    <a href="{{ route('admin.categories.index') }}"
                        class="text-sm text-blue-600 mt-4 hover:underline">Gerenciar Categorias →</a>
                </div>

                <!-- Total de Usuários -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Total de Usuários</h3>
                    <p class="mt-4 text-3xl font-semibold text-gray-900">{{ $usersCount }}</p>
                </div>
            </div>


            <!-- Últimos Anúncios -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Últimos Anúncios</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Imagem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Criado em</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentListings as $listing)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($listing->images->first())
                                        <img src="{{ asset('storage/' . $listing->images->first()->path) }}"
                                            alt="Imagem do anúncio" class="h-16 w-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-400 text-sm">Sem imagem</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $listing->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $listing->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $listing->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($listing->status)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.ads.edit', $listing) }}"
                                        class="text-blue-600 hover:text-blue-900">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum anúncio recente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Últimos Usuários -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Últimos Usuários Cadastrados</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data de Cadastro</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhum usuário recente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Gráfico de Crescimento de Anúncios -->

        </div>
    </div>

    <!-- Chart.js -->
    

</x-app-layout>
