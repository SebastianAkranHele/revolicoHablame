{{-- resources/views/home.blade.php --}}
@extends('layout')

@section('styles')
    @parent
    @vite(['resources/css/categories.css'])
@endsection

@section('content')
    <div class="container py-4">
        <!-- Título con filtro activo -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h4 fw-bold text-dark mb-0" id="section-title">
                    @if(request()->has('category_id') && request('category_id') != 'all')
                        @php
                            $category = \App\Models\Category::find(request('category_id'));
                        @endphp
                        @if($category)
                            {{ $category->name }}
                        @else
                            Sugerencias de hoy
                        @endif
                    @else
                        Sugerencias de hoy
                    @endif
                </h2>
                <small class="text-muted" id="section-subtitle">
                    @if(request()->has('category_id') && request('category_id') != 'all')
                        {{ $listings->total() }} anúncios encontrados
                    @else
                        Todos os anúncios recentes
                    @endif
                </small>
            </div>

            @if(request()->has('category_id') || request()->has('search'))
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm" id="clear-filter">
                    <i class="bi bi-x-circle me-1"></i> Limpar filtro
                </a>
            @endif
        </div>

        <!-- Grid de Anúncios -->
        <div class="row g-3" id="listings-container">
            @forelse($listings as $ad)
                <div class="col-6 col-md-4 col-lg-3 mb-4 fade-in">
                    <div class="card listing-card h-100 border-0 shadow-sm hover-lift">
                        <!-- Badges -->
                        <div class="position-absolute top-0 start-0 m-2">
                            @if ($ad->condition == 'new')
                                <span class="badge bg-success">Novo</span>
                            @elseif($ad->condition == 'used')
                                <span class="badge bg-secondary">Usado</span>
                            @endif
                        </div>

                        <!-- Image -->
                        <a href="{{ route('public.show', $ad->slug) }}" class="text-decoration-none">
                            <div class="card-img-top position-relative overflow-hidden" style="height: 180px;">
                                <img src="{{ $ad->images->first() ? asset('storage/' . $ad->images->first()->path) : asset('images/placeholder.png') }}"
                                    class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $ad->title }}"
                                    loading="lazy">
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Price -->
                            <div class="mb-2">
                                <span class="h6 fw-bold text-success mb-0">
                                    @if ($ad->price)
                                        {{ number_format($ad->price, 0, ',', '.') }} KZ
                                    @else
                                        A negociar
                                    @endif
                                </span>
                            </div>

                            <!-- Title -->
                            <a href="{{ route('public.show', $ad->slug) }}" class="text-decoration-none text-dark">
                                <h6 class="card-title mb-2 line-clamp-2" style="min-height: 40px; font-size: 14px;">
                                    {{ \Illuminate\Support\Str::limit($ad->title, 50) }}
                                </h6>
                            </a>

                            <!-- Location -->
                            <div class="mt-auto">
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ \Illuminate\Support\Str::limit($ad->location, 20) }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-search display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted">Nenhum anúncio encontrado</h4>
                        <p class="text-muted mb-4">
                            @if(request()->has('search'))
                                Tente usar outros termos de busca
                            @elseif(request()->has('category_id'))
                                Tente outra categoria
                            @else
                                Não há anúncios disponíveis no momento
                            @endif
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bi bi-house me-1"></i> Ver todos os anúncios
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if ($listings->hasPages())
            <div class="mt-4 mb-5">
                <div class="d-flex justify-content-center">
                    {{ $listings->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        // Efectos hover para cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.hover-lift');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'transform 0.3s ease';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Actualizar título según categoría activa
            function updatePageTitle() {
                const urlParams = new URLSearchParams(window.location.search);
                const categoryId = urlParams.get('category_id');
                const searchTerm = urlParams.get('search');

                if (categoryId && categoryId !== 'all') {
                    // Podrías hacer una petición AJAX para obtener el nombre de la categoría
                    // o pasar el nombre desde el backend
                    console.log('Categoría activa:', categoryId);
                } else if (searchTerm) {
                    document.getElementById('section-title').textContent = `Resultados para "${searchTerm}"`;
                    document.getElementById('section-subtitle').textContent = 'Resultados da sua pesquisa';
                }
            }

            // Ejecutar al cargar
            updatePageTitle();

            // Escuchar cambios en la URL
            window.addEventListener('popstate', updatePageTitle);
        });
    </script>
@endsection
