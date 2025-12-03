@extends('layout')

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
                             class="img-fluid rounded"
                             alt="{{ $listing->title }}"
                             style="max-height: 500px; object-fit: contain;">
                    </div>

                    <!-- Miniaturas -->
                    @if($listing->images->count() > 1)
                    <div class="row g-2">
                        @foreach($listing->images as $image)
                        <div class="col-3 col-sm-2">
                            <img src="{{ asset('storage/'.$image->path) }}"
                                 class="img-thumbnail cursor-pointer hover-opacity"
                                 alt="Imagem {{ $loop->iteration }}"
                                 onclick="changeMainImage('{{ asset('storage/'.$image->path) }}')"
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
                            <svg class="bi bi-geo-alt me-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="#geo-alt"/>
                            </svg>
                            <span class="text-muted">{{ $listing->location }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Descrição -->
                    <div class="mb-4">
                        <h5 class="mb-3">Descrição</h5>
                        <div class="description-content" style="white-space: pre-line; line-height: 1.6;">
                            {{ $listing->description }}
                        </div>
                    </div>

                    <!-- Características -->
                    <div class="row g-3 mb-4">
                        @if($listing->condition)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <svg class="bi bi-tag me-3" width="24" height="24" fill="currentColor">
                                    <use xlink:href="#tag"/>
                                </svg>
                                <div>
                                    <small class="text-muted">Condição</small>
                                    <div class="fw-medium">{{ $listing->condition == 'new' ? 'Novo' : 'Usado' }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($listing->category)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <svg class="bi bi-grid me-3" width="24" height="24" fill="currentColor">
                                    <use xlink:href="#grid"/>
                                </svg>
                                <div>
                                    <small class="text-muted">Categoria</small>
                                    <div class="fw-medium">{{ $listing->category->name }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <svg class="bi bi-calendar me-3" width="24" height="24" fill="currentColor">
                                    <use xlink:href="#calendar"/>
                                </svg>
                                <div>
                                    <small class="text-muted">Publicado</small>
                                    <div class="fw-medium">{{ $listing->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <svg class="bi bi-eye me-3" width="24" height="24" fill="currentColor">
                                    <use xlink:href="#eye"/>
                                </svg>
                                <div>
                                    <small class="text-muted">Visualizações</small>
                                    <div class="fw-medium">{{ rand(50, 500) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de ação -->
                    @if($listing->phone)
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$listing->phone) }}?text=Olá, estou interessado no seu anúncio: {{ $listing->title }}"
                           target="_blank"
                           class="btn btn-success btn-lg flex-fill">
                            <svg class="bi bi-whatsapp me-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="#whatsapp"/>
                            </svg>
                            WhatsApp
                        </a>
                        <a href="tel:{{ $listing->phone }}"
                           class="btn btn-primary btn-lg flex-fill">
                            <svg class="bi bi-telephone me-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="#telephone"/>
                            </svg>
                            Ligar
                        </a>
                        <button class="btn btn-outline-secondary btn-lg flex-fill" onclick="copyPhoneNumber()">
                            <svg class="bi bi-clipboard me-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="#clipboard"/>
                            </svg>
                            Copiar Número
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Anúncios similares (opcional) -->
            @if($similarListings && $similarListings->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Anúncios Similares</h5>
                    <div class="row g-3">
                        @foreach($similarListings as $similar)
                        <div class="col-md-6">
                            <a href="{{ route('public.show', $similar->slug) }}" class="text-decoration-none text-dark">
                                <div class="card h-100 border hover-shadow">
                                    <div class="row g-0 h-100">
                                        <div class="col-4">
                                            <img src="{{ $similar->images->first() ? asset('storage/'.$similar->images->first()->path) : asset('images/placeholder.png') }}"
                                                 class="img-fluid rounded-start h-100 w-100"
                                                 alt="{{ $similar->title }}"
                                                 style="object-fit: cover;">
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
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informações do Vendedor</h5>

                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px;">
                            <svg class="bi bi-person" width="24" height="24" fill="currentColor">
                                <use xlink:href="#person"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold">{{ $listing->user->name ?? 'Anónimo' }}</div>
                            <small class="text-muted">Membro desde {{ $listing->user->created_at->format('Y') ?? '2024' }}</small>
                        </div>
                    </div>

                    @if($listing->phone)
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <svg class="bi bi-telephone me-2" width="18" height="18" fill="currentColor">
                                <use xlink:href="#telephone"/>
                            </svg>
                            <span class="fw-medium">Telefone</span>
                        </div>
                        <div class="fs-5 fw-bold text-dark">{{ $listing->phone }}</div>
                    </div>
                    @endif

                    @if($listing->email)
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <svg class="bi bi-envelope me-2" width="18" height="18" fill="currentColor">
                                <use xlink:href="#envelope"/>
                            </svg>
                            <span class="fw-medium">Email</span>
                        </div>
                        <div class="text-break">{{ $listing->email }}</div>
                    </div>
                    @endif

                    <!-- Estatísticas do vendedor -->
                    <div class="border-top pt-3 mt-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="fw-bold">{{ rand(5, 50) }}</div>
                                <small class="text-muted">Anúncios</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold">{{ rand(80, 99) }}%</div>
                                <small class="text-muted">Avaliação</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold">{{ rand(1, 30) }}</div>
                                <small class="text-muted">Dias online</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dicas de segurança -->
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning bg-opacity-10">
                    <h6 class="mb-0">
                        <svg class="bi bi-shield-check me-2" width="20" height="20" fill="currentColor">
                            <use xlink:href="#shield-check"/>
                        </svg>
                        Dicas de Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">✔️ Encontre-se em locais públicos</li>
                        <li class="mb-2">✔️ Verifique o produto antes de comprar</li>
                        <li class="mb-2">✔️ Não pague adiantado sem garantias</li>
                        <li class="mb-2">✔️ Guarde todas as conversas</li>
                        <li>✔️ Denuncie comportamentos suspeitos</li>
                    </ul>
                </div>
            </div>

            <!-- Compartilhar -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">Compartilhar este anúncio</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <svg class="bi bi-facebook" width="16" height="16" fill="currentColor">
                                <use xlink:href="#facebook"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $listing->title }}"
                           target="_blank"
                           class="btn btn-outline-info btn-sm">
                            <svg class="bi bi-twitter" width="16" height="16" fill="currentColor">
                                <use xlink:href="#twitter"/>
                            </svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ $listing->title }} {{ url()->current() }}"
                           target="_blank"
                           class="btn btn-outline-success btn-sm">
                            <svg class="bi bi-whatsapp" width="16" height="16" fill="currentColor">
                                <use xlink:href="#whatsapp"/>
                            </svg>
                        </a>
                        <button onclick="copyLink()" class="btn btn-outline-secondary btn-sm">
                            <svg class="bi bi-link-45deg" width="16" height="16" fill="currentColor">
                                <use xlink:href="#link-45deg"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Denunciar -->
            <div class="mt-4 text-center">
                <a href="#" class="text-decoration-none small text-muted">
                    <svg class="bi bi-flag me-1" width="14" height="14" fill="currentColor">
                        <use xlink:href="#flag"/>
                    </svg>
                    Denunciar este anúncio
                </a>
            </div>
        </div>
    </div>
</div>

<!-- SVG Icons (colocar no layout ou aqui) -->
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="geo-alt" viewBox="0 0 16 16">
        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
    </symbol>
    <symbol id="tag" viewBox="0 0 16 16">
        <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z"/>
        <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z"/>
    </symbol>
    <symbol id="grid" viewBox="0 0 16 16">
        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
    </symbol>
    <symbol id="calendar" viewBox="0 0 16 16">
        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
    </symbol>
    <symbol id="eye" viewBox="0 0 16 16">
        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
    </symbol>
    <symbol id="whatsapp" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
    </symbol>
    <symbol id="telephone" viewBox="0 0 16 16">
        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
    </symbol>
    <symbol id="clipboard" viewBox="0 0 16 16">
        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
    </symbol>
    <symbol id="person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
    </symbol>
    <symbol id="envelope" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
    </symbol>
    <symbol id="shield-check" viewBox="0 0 16 16">
        <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
        <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
    </symbol>
</svg>

<script>
// Função para mudar a imagem principal
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}

// Função para copiar número de telefone
function copyPhoneNumber() {
    const phone = '{{ $listing->phone }}';
    navigator.clipboard.writeText(phone).then(() => {
        alert('Número copiado: ' + phone);
    }).catch(err => {
        console.error('Erro ao copiar: ', err);
    });
}

// Função para copiar link
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copiado!');
    }).catch(err => {
        console.error('Erro ao copiar: ', err);
    });
}

// Adicionar classe hover para miniaturas
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.hover-opacity');
    thumbnails.forEach(thumb => {
        thumb.addEventListener('mouseenter', () => {
            thumb.style.opacity = '0.8';
        });
        thumb.addEventListener('mouseleave', () => {
            thumb.style.opacity = '1';
        });
    });
});
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}

.hover-opacity {
    transition: opacity 0.2s ease;
}

.description-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.card.hover-shadow:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    transition: box-shadow 0.3s ease;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}
</style>
@endsection
