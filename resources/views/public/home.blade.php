@extends('layout')

@section('content')
<div class="container-fluid px-0">
    <!-- Botões de Navegação -->
    <div class="bg-white border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex w-100 justify-content-center py-3">
                        <!-- Botões no estilo da imagem -->
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <!-- Botão "Para Ti" -->
                            <a href="#sugerencias"
                               class="btn-navigation-img active"
                               data-target="sugerencias">
                                Para Ti
                            </a>

                            <!-- Botão "Categorías" -->
                            <a href="#categorias"
                               class="btn-navigation-img"
                               data-target="categorias">
                                Categorías
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="container py-4">
        <!-- Seção Sugerencias (Para Ti) -->
        <div id="sugerencias" class="content-section active">
            <!-- Título -->
          

            <!-- Grid de Anúncios -->
            <div class="row g-3">
                @forelse($listings as $ad)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card listing-card h-100 border-0 shadow-sm">
                        <!-- Badges -->
                        <div class="position-absolute top-0 start-0 m-2">
                            @if($ad->condition == 'new')
                                <span class="badge bg-success">Novo</span>
                            @elseif($ad->condition == 'used')
                                <span class="badge bg-secondary">Usado</span>
                            @endif
                        </div>

                        <!-- Image -->
                        <a href="{{ route('public.show', $ad->slug) }}" class="text-decoration-none">
                            <div class="card-img-top position-relative overflow-hidden" style="height: 180px;">
                                <img src="{{ $ad->images->first() ? asset('storage/'.$ad->images->first()->path) : asset('images/placeholder.png') }}"
                                     class="img-fluid w-100 h-100 object-fit-cover"
                                     alt="{{ $ad->title }}"
                                     loading="lazy">
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Price -->
                            <div class="mb-2">
                                <span class="h6 fw-bold text-success mb-0">
                                    @if($ad->price)
                                        {{ number_format($ad->price, 0, ',', '.') }} USD
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
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginação -->
            @if($listings->hasPages())
            <div class="mt-4 mb-5">
                <div class="d-flex justify-content-center">
                    {{ $listings->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>

        <!-- Seção Categorías (inicialmente escondida) -->
        <div id="categorias" class="content-section" style="display: none;">
            <!-- Lista de Categorías -->
            <div class="row g-3">
                @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card category-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <!-- Ícone da Categoria -->
                            <div class="mb-3">
                                <div class="category-icon rounded-circle bg-primary bg-opacity-10 p-3 mx-auto"
                                     style="width: 70px; height: 70px;">
                                    <i class="bi bi-{{ $category->icon ?? 'box' }} fs-3 text-primary"></i>
                                </div>
                            </div>

                            <!-- Nome da Categoria -->
                            <h5 class="fw-bold mb-2">{{ $category->name }}</h5>

                            <!-- Contagem de Anúncios -->
                            <div class="text-muted small mb-3">
                                {{ $category->listings_count ?? 0 }} anúncios
                            </div>

                            <!-- Botão Ver -->
                            <a href="{{ route('home', ['category_id' => $category->id]) }}"
                               class="btn btn-outline-primary btn-sm w-100">
                                Ver anúncios
                            </a>

                            <!-- Subcategorías (se existirem) -->
                            @if($category->children->count() > 0)
                            <div class="mt-3 pt-3 border-top">
                                <div class="small text-muted mb-2">Subcategorías:</div>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    @foreach($category->children as $subcategory)
                                    <a href="{{ route('home', ['category_id' => $subcategory->id]) }}"
                                       class="badge bg-light text-dark text-decoration-none">
                                        {{ $subcategory->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-grid display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted">Nenhuma categoria disponível</h4>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer básico -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">© {{ date('Y') }} Hablame. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</div>

<style>
/* ESTILO DOS BOTÕES COMO NA IMAGEM */
.btn-navigation-img {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 24px;
    background: linear-gradient(135deg, #7B61FF 0%, #6C4DFF 100%);
    color: white !important;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    font-size: 15px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(108, 77, 255, 0.2);
    min-width: 100px;
    text-align: center;
}

.btn-navigation-img:hover {
    background: linear-gradient(135deg, #6C4DFF 0%, #5B3DFF 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(108, 77, 255, 0.3);
    color: white !important;
    text-decoration: none;
}

.btn-navigation-img.active {
    background: linear-gradient(135deg, #5B3DFF 0%, #4A2CFF 100%);
    box-shadow: 0 6px 16px rgba(108, 77, 255, 0.4);
    position: relative;
}

.btn-navigation-img.active::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 3px;
    background-color: white;
    border-radius: 3px;
    opacity: 0.8;
}

/* Estilos antigos dos botões de navegação (mantidos para compatibilidade) */
.btn-navigation {
    color: #666;
    background-color: #f8f9fa;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-navigation:hover {
    color: #0d6efd;
    background-color: #e9ecef;
}

.btn-navigation.active {
    color: #0d6efd;
    background-color: white;
    border-bottom: 3px solid #0d6efd;
}

/* Cards */
.listing-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.listing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.category-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(13, 110, 253, 0.1) !important;
}

.category-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    background-color: #0d6efd !important;
}

.category-card:hover .category-icon i {
    color: white !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.object-fit-cover {
    object-fit: cover;
}

/* Animação suave para troca de seções */
.content-section {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.content-section.active {
    opacity: 1;
    transform: translateY(0);
    display: block !important;
}

/* Estilo para o contêiner de botões */
.d-flex.flex-wrap.gap-3 {
    gap: 12px !important;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-navigation-img {
        padding: 8px 16px;
        font-size: 14px;
        min-width: 80px;
    }

    .btn-navigation {
        font-size: 14px !important;
        padding: 12px 0 !important;
    }

    .category-icon {
        width: 60px !important;
        height: 60px !important;
    }

    .d-flex.flex-wrap.gap-3 {
        gap: 8px !important;
    }
}

@media (max-width: 480px) {
    .btn-navigation-img {
        padding: 6px 12px;
        font-size: 13px;
        min-width: 70px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos - agora usando os botões com estilo da imagem
    const buttons = document.querySelectorAll('.btn-navigation-img[data-target]');
    const sections = document.querySelectorAll('.content-section');

    // Função para alternar seções
    function switchSection(targetId) {
        // Remove active de todos os botões
        buttons.forEach(btn => {
            btn.classList.remove('active');
        });

        // Esconde todas as seções
        sections.forEach(section => {
            section.classList.remove('active');
            section.style.display = 'none';
        });

        // Ativa o botão clicado
        const activeButton = document.querySelector(`.btn-navigation-img[data-target="${targetId}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }

        // Mostra a seção correspondente
        const activeSection = document.getElementById(targetId);
        if (activeSection) {
            activeSection.style.display = 'block';
            // Pequeno delay para a animação CSS funcionar
            setTimeout(() => {
                activeSection.classList.add('active');
            }, 10);
        }

        // Salvar no localStorage
        localStorage.setItem('activeSection', targetId);
    }

    // Adiciona evento de clique aos botões
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            if (target) {
                switchSection(target);
            }
        });
    });

    // Verifica hash da URL
    const hash = window.location.hash.substring(1);
    if (hash && (hash === 'sugerencias' || hash === 'categorias')) {
        switchSection(hash);
    } else {
        // Verifica localStorage
        const savedSection = localStorage.getItem('activeSection');
        if (savedSection && (savedSection === 'sugerencias' || savedSection === 'categorias')) {
            switchSection(savedSection);
        }
    }

    // Inicializar tooltips do Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
