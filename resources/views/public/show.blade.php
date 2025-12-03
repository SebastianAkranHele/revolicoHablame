{{-- resources/views/public/show.blade.php --}}
@extends('layout')

@section('styles')
    @parent
     @vite(['resources/css/listing-show.css'])
@endsection

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            @if($listing->category)
                <li class="breadcrumb-item"><a href="#">{{ $listing->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($listing->title, 30) }}</li>
        </ol>
    </nav>

    <!-- Anúncio -->
    <div class="row">
        <!-- Coluna principal -->
        <div class="col-lg-8">
            <!-- Galeria de imagens -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <!-- Imagem principal -->
                    <div class="text-center mb-3">
                        <img id="mainImage"
                             src="{{ $listing->images->first() ? asset('storage/'.$listing->images->first()->path) : asset('images/placeholder.png') }}"
                             class="img-fluid rounded main-image"
                             alt="{{ $listing->title }}">
                    </div>

                    <!-- Miniaturas -->
                    @if($listing->images->count() > 1)
                    <div class="row g-2 thumbnail-container">
                        @foreach($listing->images as $image)
                        <div class="col-3 col-sm-2">
                            <img src="{{ asset('storage/'.$image->path) }}"
                                 class="img-thumbnail thumbnail"
                                 alt="Imagem {{ $loop->iteration }}"
                                 data-image-src="{{ asset('storage/'.$image->path) }}"
                                 style="height: 80px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Detalhes do anúncio -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-3 fw-bold">{{ $listing->title }}</h1>

                    <!-- Preço -->
                    @if($listing->price)
                    <div class="mb-4">
                        <span class="display-6 fw-bold text-success">
                            {{ number_format($listing->price, 2, ',', '.') }} KZ
                        </span>
                    </div>
                    @endif

                    <!-- Localização -->
                    @if($listing->location)
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span class="text-muted">{{ $listing->location }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Descrição -->
                    <div class="mb-4">
                        <h5 class="mb-3">Descrição</h5>
                        <div class="description-content">
                            {{ $listing->description }}
                        </div>
                    </div>

                    <!-- Características -->
                    <div class="row g-3 mb-4">
                        @if($listing->condition)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded feature-item">
                                <i class="bi bi-tag me-3"></i>
                                <div>
                                    <small class="text-muted">Condição</small>
                                    <div class="fw-medium">{{ $listing->condition == 'new' ? 'Novo' : 'Usado' }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($listing->category)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded feature-item">
                                <i class="bi bi-grid me-3"></i>
                                <div>
                                    <small class="text-muted">Categoria</small>
                                    <div class="fw-medium">{{ $listing->category->name }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded feature-item">
                                <i class="bi bi-calendar me-3"></i>
                                <div>
                                    <small class="text-muted">Publicado</small>
                                    <div class="fw-medium">{{ $listing->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded feature-item">
                                <i class="bi bi-eye me-3"></i>
                                <div>
                                    <small class="text-muted">Visualizações</small>
                                    <div class="fw-medium">{{ rand(50, 500) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de ação -->
                    @if($listing->phone)
                    <div class="d-flex flex-wrap gap-2 mb-4 action-buttons">
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$listing->whatsapp) }}?text=Olá, estou interessado no seu anúncio: {{ $listing->title }}"
                           target="_blank"
                           class="btn btn-success btn-lg flex-fill">
                            <i class="bi bi-whatsapp me-2"></i>
                            WhatsApp
                        </a>
                        <a href="tel:{{ $listing->phone }}"
                           class="btn btn-primary btn-lg flex-fill">
                            <i class="bi bi-telephone me-2"></i>
                            Ligar
                        </a>
                        <button class="btn btn-outline-secondary btn-lg flex-fill copy-phone-btn">
                            <i class="bi bi-clipboard me-2"></i>
                            Copiar Número
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Anúncios similares -->
            @if($similarListings && $similarListings->count() > 0)
            <div class="card shadow-sm similar-listings">
                <div class="card-body">
                    <h5 class="card-title mb-4">Anúncios Similares</h5>
                    <div class="row g-3">
                        @foreach($similarListings as $similar)
                        <div class="col-md-6">
                            <a href="{{ route('public.show', $similar->slug) }}" class="text-decoration-none text-dark">
                                <div class="card h-100 border listing-card">
                                    <div class="row g-0 h-100">
                                        <div class="col-4">
                                            <img src="{{ $similar->images->first() ? asset('storage/'.$similar->images->first()->path) : asset('images/placeholder.png') }}"
                                                 class="img-fluid rounded-start listing-image"
                                                 alt="{{ $similar->title }}">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-3">
                                                <h6 class="card-title mb-1">{{ Str::limit($similar->title, 40) }}</h6>
                                                @if($similar->price)
                                                <p class="card-text text-success fw-bold mb-1">
                                                    {{ number_format($similar->price, 2, ',', '.') }} KZ
                                                </p>
                                                @endif
                                                <small class="text-muted">{{ $similar->location }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <!-- Card do vendedor -->
<div class="card shadow-sm mb-4 seller-card">
    <div class="card-body">
        <h5 class="card-title mb-4">Informações do Vendedor</h5>

        <div class="d-flex align-items-center mb-4">
            <div class="seller-avatar">
                <i class="bi bi-person"></i>
            </div>
            <div>
                <div class="fw-bold">{{ $listing->user->name ?? 'Anónimo' }}</div>
                <small class="text-muted">Membro desde {{ $listing->user->created_at->format('Y') ?? '2024' }}</small>
            </div>
        </div>

        @if($listing->phone)
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-telephone me-2"></i>
                <span class="fw-medium">Telefone</span>
            </div>
            <div class="fs-5 fw-bold text-dark phone-number">{{ $listing->phone }}</div>
        </div>
        @endif

        @if($listing->whatsapp || $listing->phone)
       <div class="mb-3">
    <div class="d-flex align-items-center mb-2">
        <i class="bi bi-whatsapp me-2 text-success"></i>
        <span class="fw-medium">WhatsApp</span>
    </div>
    @if($listing->whatsapp)
        <!-- Se tiver número específico para WhatsApp -->
        <div class="fs-5 fw-bold text-dark whatsapp-number">{{ $listing->whatsapp }}</div>
    @elseif($listing->phone)
        <!-- Se não tiver WhatsApp específico, usar o telefone -->
        <div class="fs-5 fw-bold text-dark whatsapp-number">{{ $listing->phone }}</div>
    @endif
</div>
        @endif
    </div>
</div>

            <!-- Dicas de segurança -->
            <div class="card shadow-sm security-tips">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Dicas de Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="security-tips-list">
                        <li>Encontre-se em locais públicos</li>
                        <li>Verifique o produto antes de comprar</li>
                        <li>Não pague adiantado sem garantias</li>
                        <li>Guarde todas as conversas</li>
                        <li>Denuncie comportamentos suspeitos</li>
                    </ul>
                </div>
            </div>

            <!-- Compartilhar -->
            <div class="card shadow-sm mt-4 share-card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Compartilhar este anúncio</h6>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $listing->title }}"
                           target="_blank"
                           class="btn btn-outline-info btn-sm">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ $listing->title }} {{ url()->current() }}"
                           target="_blank"
                           class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <button class="btn btn-outline-secondary btn-sm copy-link-btn">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Denunciar -->
            <div class="mt-4 text-center report-section">
                <a href="#" class="text-decoration-none small text-muted">
                    <i class="bi bi-flag me-1"></i>
                    Denunciar este anúncio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    @vite(['resources/js/listing-show.js'])
@endsection
