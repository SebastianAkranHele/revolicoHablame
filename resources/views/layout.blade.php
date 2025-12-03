<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hablame!')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            padding-top: 95px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* LOGO MAIOR */
        .navbar-brand img {
            height: 75px;
            object-fit: contain;
        }

        /* WRAPPER IGUAL OLX */
        .search-wrapper {
            display: flex;
            flex: 1;
            background: #f2f4f5;
            border-radius: 40px;
            overflow: hidden;
            padding-left: 15px;
            align-items: center;
            max-width: 650px;
            margin-left: 20px;
        }

        /* INPUT */
        .search-wrapper input {
            border: none;
            background: transparent;
            flex: 1;
            padding: 10px;
            outline: none;
            font-size: 15px;
        }

        /* BOTÃO REDONDO ESTILO OLX */
        .search-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #3a77ff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }

        .search-btn i {
            color: white;
            font-size: 18px;
        }

        /* LINKS */
        .navbar-nav .nav-link {
            font-size: 16px;
            margin-left: 15px;
            color: #333 !important;
        }

        /* DROPDOWN DE CATEGORÍAS - ESTILO MODERNO */
        .categories-dropdown {
            min-width: 320px !important;
            max-height: 70vh !important;
            overflow-y: auto;
            border: none !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
            border-radius: 12px !important;
            margin-top: 10px !important;
            padding: 0 !important;
        }

        .categories-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f3f4;
            background-color: #f8f9fa;
            border-radius: 12px 12px 0 0;
        }

        .categories-list {
            padding: 0.5rem 0;
        }

        .category-item {
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.2s ease;
            display: block;
            text-decoration: none;
            color: #333;
        }

        .category-item:hover {
            background-color: #f8f9fa;
            padding-left: 1.75rem;
            text-decoration: none;
            color: #333;
        }

        .category-main {
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(58, 119, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .category-icon i {
            color: #3a77ff;
            font-size: 1rem;
        }

        .category-badge {
            font-size: 0.75rem;
            padding: 0.25em 0.6em;
            background-color: rgba(58, 119, 255, 0.1);
            color: #3a77ff;
            border-radius: 10px;
        }

        .subcategory {
            padding-left: 2.5rem !important;
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
        }

        .subcategory:hover {
            color: #3a77ff !important;
        }

        .subcategory i {
            margin-right: 8px;
            font-size: 0.8rem;
        }

        .view-all {
            border-top: 1px solid #f1f3f4;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        /* FOOTER BÁSICO */
        .footer-basic {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        /* Logo no footer */
        .footer-logo {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        /* Social icons */
        .social-icons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .social-icon {
            color: #6c757d;
            text-decoration: none;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .social-icon:hover {
            color: #3a77ff;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .search-wrapper {
                margin: 10px 0;
                max-width: 100%;
                order: 3;
                width: 100%;
            }

            .categories-dropdown {
                min-width: 100% !important;
                position: fixed !important;
                left: 10px !important;
                right: 10px !important;
                max-width: calc(100% - 20px) !important;
            }

            .navbar-nav {
                margin-top: 10px;
            }

            /* Footer responsive */
            .footer-basic .row > div {
                text-align: center;
                margin-bottom: 1rem;
            }

            .footer-basic .row > div:last-child {
                margin-bottom: 0;
            }

            .social-icons {
                justify-content: center !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                height: 60px;
            }

            body {
                padding-top: 80px;
            }

            .footer-logo {
                height: 50px;
            }
        }

        @media (max-width: 576px) {
            .footer-basic {
                padding: 1rem 0;
            }
        }

        /* Indicador de categoría activa */
        .category-active {
            background-color: rgba(58, 119, 255, 0.1) !important;
            color: #3a77ff !important;
            font-weight: 600;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- NAVBAR FIXO -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </a>

            <!-- Botón móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">

                <!-- BARRA DE BUSCA -->
                <form class="search-wrapper" method="GET" action="{{ route('home') }}">
                    <input type="text" name="search" placeholder="Buscar em Hablame..." value="{{ request('search') }}">
                    <button class="search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- LINKS DIREITA -->
                <ul class="navbar-nav ms-auto align-items-center">

                    <!-- Dropdown de Categorías -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="categoriesDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid-3x3-gap me-1"></i>
                            <span>Categorías</span>
                        </a>
                        <div class="dropdown-menu categories-dropdown" aria-labelledby="categoriesDropdown">
                            <!-- Cabecera -->
                            <div class="categories-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">Todas as Categorías</h6>
                                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">
                                        Ver Tudo
                                    </a>
                                </div>

                                <!-- Búsqueda en categorías -->
                                <div class="mt-2">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 search-categories"
                                               placeholder="Buscar categoría...">
                                    </div>
                                </div>
                            </div>

                            <!-- Lista de categorías -->
                            <div class="categories-list">
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories->whereNull('parent_id')->take(8) as $category)
                                        <!-- Categoría principal -->
                                        <a href="{{ route('home') }}?category_id={{ $category->id }}"
                                           class="category-item category-main"
                                           data-category-id="{{ $category->id }}">
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon">
                                                    <i class="bi bi-tag"></i>
                                                </div>
                                                <span>{{ $category->name }}</span>
                                            </div>
                                            <span class="category-badge">{{ $category->listings_count ?? 0 }}</span>
                                        </a>

                                        <!-- Subcategorías -->
                                        @if($category->children->count() > 0)
                                            @foreach($category->children->take(3) as $subcategory)
                                                <a href="{{ route('home') }}?category_id={{ $subcategory->id }}"
                                                   class="category-item subcategory"
                                                   data-category-id="{{ $subcategory->id }}">
                                                    <i class="bi bi-chevron-right"></i>
                                                    {{ $subcategory->name }}
                                                    <small class="text-muted ms-1">({{ $subcategory->listings_count ?? 0 }})</small>
                                                </a>
                                            @endforeach

                                            @if($category->children->count() > 3)
                                                <a href="{{ route('home') }}?category_id={{ $category->id }}"
                                                   class="category-item subcategory text-primary">
                                                    <i class="bi bi-plus-circle"></i>
                                                    Ver mais {{ $category->children->count() - 3 }}...
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach

                                    <!-- Ver todas -->
                                    <div class="view-all">
                                        <a href="{{ route('home') }}" class="category-item text-center text-primary">
                                            <i class="bi bi-grid-3x3 me-1"></i>
                                            Ver todas as categorías
                                        </a>
                                    </div>
                                @else
                                    <div class="category-item text-center py-3">
                                        <i class="bi bi-tags display-6 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Carregando categorías...</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>

                    @auth
                        <!-- Links simples para usuario autenticado -->
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    @else
                        <!-- Links no autenticado -->
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Entrar</a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER BÁSICO - COM LOGO À ESQUERDA, COPYRIGHT CENTRO, REDES SOCIAIS DIREITA -->
    <footer class="footer-basic">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo à esquerda -->
                <div class="col-lg-3 col-md-4 col-sm-12 mb-3 mb-md-0">
                    <div class="logo-container">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Hablame" class="footer-logo">
                    </div>
                </div>

                <!-- Copyright no centro -->
                <div class="col-lg-6 col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} Hablame. Todos os direitos reservados.</p>
                </div>

                <!-- Redes sociais à direita -->
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="social-icons justify-content-md-end justify-content-center">
                        <a href="#" class="social-icon" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="#" class="social-icon" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript para el dropdown de categorías -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para resaltar categoría activa
            function highlightActiveCategory() {
                const urlParams = new URLSearchParams(window.location.search);
                const categoryId = urlParams.get('category_id');

                if (categoryId) {
                    // Remover clase activa de todos
                    document.querySelectorAll('.category-item').forEach(item => {
                        item.classList.remove('category-active');
                    });

                    // Añadir clase activa a la categoría correspondiente
                    const activeItems = document.querySelectorAll(`[data-category-id="${categoryId}"]`);
                    activeItems.forEach(item => {
                        item.classList.add('category-active');
                    });
                }
            }

            // Funcionalidad de búsqueda en categorías
            const searchInput = document.querySelector('.search-categories');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const items = document.querySelectorAll('.category-item');

                    items.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        if (searchTerm === '' || text.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                const dropdown = document.querySelector('.categories-dropdown');
                const toggle = document.getElementById('categoriesDropdown');

                if (dropdown && toggle &&
                    !dropdown.contains(e.target) &&
                    !toggle.contains(e.target)) {
                    const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                    if (bsDropdown) bsDropdown.hide();
                }
            });

            // Resaltar categoría activa al cargar
            highlightActiveCategory();

            // Escuchar cambios en la URL (para navegación con botones atrás/adelante)
            window.addEventListener('popstate', function() {
                setTimeout(highlightActiveCategory, 100);
            });

            // Mejorar experiencia en móviles
            if (window.innerWidth <= 992) {
                const dropdownMenu = document.querySelector('.categories-dropdown');
                if (dropdownMenu) {
                    dropdownMenu.style.maxHeight = '60vh';
                }
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
