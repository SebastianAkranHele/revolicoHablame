// resources/js/categories.js - VERSIÓN CORREGIDA

class CategoriesManager {
    constructor() {
        this.buttons = document.querySelectorAll('.btn-navigation-img[data-target]');
        this.sections = document.querySelectorAll('.content-section');
        this.categoryLinks = document.querySelectorAll('.category-filter, .subcategory-filter');
        this.clearFilterBtn = document.getElementById('clear-filter');
        this.sectionTitle = document.getElementById('section-title');
        this.sectionSubtitle = document.getElementById('section-subtitle');
        this.listingsContainer = document.getElementById('listings-container');

        console.log('CategoriesManager inicializado');
        console.log('Elementos encontrados:', {
            botões: this.buttons.length,
            seções: this.sections.length,
            linksCategoria: this.categoryLinks.length
        });

        this.init();
    }

    init() {
        this.setupNavigation();
        this.setupCategoryLinks();
        this.setupClearFilter();
        this.checkInitialState();

        // Escuchar clicks en el logo/icono de navegación para resetear
        this.setupLogoReset();
    }

    setupNavigation() {
        console.log('Configurando navegação...');

        // Adiciona evento de clique aos botões de navegação
        this.buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const target = button.getAttribute('data-target');
                console.log(`Botão clicado: ${button.textContent.trim()} -> ${target}`);

                if (target) {
                    this.switchSection(target, true); // true = guardar en localStorage
                }
            });
        });

        // Verifica hash da URL
        const hash = window.location.hash.substring(1);
        console.log('Hash da URL:', hash);

        // Verificar parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const hasCategoryFilter = urlParams.has('category_id');

        console.log('Parâmetros URL:', {
            hasCategoryFilter: hasCategoryFilter,
            pathname: window.location.pathname
        });

        // Si hay filtro de categoría, mostrar "Para Ti"
        if (hasCategoryFilter) {
            console.log('Filtro de categoria detectado, mostrando "Para Ti"');
            this.switchSection('sugerencias', false); // false = no guardar en localStorage
        }
        // Si hay hash en la URL, usarlo
        else if (hash && (hash === 'sugerencias' || hash === 'categorias')) {
            this.switchSection(hash, false); // false = no guardar (ya viene de la URL)
        } else {
            // Verifica localStorage SOLO si estamos en la página principal sin filtros
            const savedSection = localStorage.getItem('activeSection');
            console.log('Seção salva no localStorage:', savedSection);

            // Solo usar localStorage si no estamos llegando de otra página
            // y si estamos en la página principal exacta (sin parámetros)
            if (savedSection && (savedSection === 'sugerencias' || savedSection === 'categorias')
                && !hasCategoryFilter
                && window.location.pathname === '/') {
                this.switchSection(savedSection, false);
            } else {
                // Por defecto, mostrar "Para Ti"
                this.switchSection('sugerencias', false);
            }
        }
    }

    switchSection(targetId, saveToStorage = true) {
        console.log(`Alternando para: ${targetId}, guardar: ${saveToStorage}`);

        // Validar seção
        const targetSection = document.getElementById(targetId);
        if (!targetSection) {
            console.error(`Seção ${targetId} não encontrada!`);
            return;
        }

        // 1. Atualizar botões
        this.buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-target') === targetId) {
                btn.classList.add('active');
            }
        });

        // 2. Atualizar seções
        this.sections.forEach(section => {
            if (section.id === targetId) {
                // Mostrar seção
                section.style.display = 'block';
                // Pequeno delay para CSS transition
                setTimeout(() => {
                    section.classList.add('active');
                }, 10);
            } else {
                // Esconder outras seções
                section.style.display = 'none';
                section.classList.remove('active');
            }
        });

        // 3. Atualizar hash (solo si no es por redirección)
        if (saveToStorage) {
            window.location.hash = targetId;
        }

        // 4. Guardar en localStorage SOLO si se solicita
        if (saveToStorage) {
            localStorage.setItem('activeSection', targetId);
        }

        console.log(`Seção ${targetId} ativada`);
    }

    setupCategoryLinks() {
        console.log('Configurando links de categoria...');

        // Adicionar eventos aos links de categoria
        this.categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const categoryId = link.getAttribute('data-category-id');
                console.log(`Categoria clicada: ID ${categoryId}`);

                // Primero cambiar a "Para Ti"
                this.switchSection('sugerencias', false);

                // Después redireccionar con filtro
                setTimeout(() => {
                    const url = new URL(window.location.origin + window.location.pathname);
                    url.searchParams.set('category_id', categoryId);
                    console.log('Redirecionando para:', url.toString());
                    window.location.href = url.toString();
                }, 300);
            });
        });
    }

    setupClearFilter() {
        if (this.clearFilterBtn) {
            this.clearFilterBtn.addEventListener('click', () => {
                console.log('Limpando filtro...');
                // Limpiar localStorage también
                localStorage.setItem('activeSection', 'sugerencias');
                window.location.href = window.location.pathname;
            });
        }
    }

    setupLogoReset() {
        // Detectar clicks en el logo/icono de navegación
        // Busca elementos comunes para logo/icono
        const logoSelectors = [
            'a.navbar-brand',
            'a.logo',
            'a[href="/"]',
            'a[href="' + window.location.origin + '"]',
            '.navbar-logo',
            '.site-logo'
        ];

        logoSelectors.forEach(selector => {
            const logos = document.querySelectorAll(selector);
            logos.forEach(logo => {
                // Verificar que realmente es el logo principal (no un enlace cualquiera)
                if (logo.getAttribute('href') === '/' ||
                    logo.getAttribute('href') === window.location.origin ||
                    logo.classList.contains('navbar-brand') ||
                    logo.classList.contains('logo')) {

                    logo.addEventListener('click', (e) => {
                        console.log('Logo/Home clicado - reseteando a "Para Ti"');
                        // Guardar "Para Ti" en localStorage
                        localStorage.setItem('activeSection', 'sugerencias');
                        // No necesitamos hacer nada más, la página se recargará
                    });
                }
            });
        });

        // También escuchar eventos de popstate (cuando se usa el botón atrás/adelante)
        window.addEventListener('popstate', (e) => {
            console.log('Popstate detectado - verificando estado');
            this.checkInitialState();
        });
    }

    checkInitialState() {
        console.log('Verificando estado inicial...');

        // Verificar se há um filtro ativo
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('category_id') && this.clearFilterBtn) {
            this.clearFilterBtn.style.display = 'block';
            console.log('Filtro ativo detectado');
        }

        // Si estamos en la página principal sin parámetros, asegurar que estamos en "Para Ti"
        if (!urlParams.toString() && window.location.pathname === '/') {
            console.log('Página principal sin filtros - verificando sección activa');
            const activeBtn = document.querySelector('.btn-navigation-img.active');
            if (activeBtn && activeBtn.getAttribute('data-target') === 'categorias') {
                console.log('Corrigindo: Categorías ativo en página principal - mudando para "Para Ti"');
                this.switchSection('sugerencias', false);
            }
        }
    }
}

// Código de inicialización y funções globais
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado - Iniciando CategoriesManager...');

    // Verificar si estamos llegando de otra página (no es un refresh)
    const isPageLoad = performance.getEntriesByType("navigation")[0]?.type === "navigate";
    console.log('Tipo de navegação:', isPageLoad ? 'Nova página' : 'Refresh');

    try {
        // Criar instância global
        window.categoriesManager = new CategoriesManager();
        console.log('CategoriesManager criado com sucesso!');

        // Verificação de emergência após 1 segundo
        setTimeout(() => {
            const categoriasSection = document.getElementById('categorias');
            const categoriasBtn = document.querySelector('[data-target="categorias"]');

            // Se o botão categorias não está funcionando
            if (categoriasBtn && !categoriasBtn.classList.contains('active') &&
                categoriasSection && categoriasSection.style.display === 'none') {

                console.log('Configurando fallback de emergência...');

                // Adicionar listener direto como fallback
                categoriasBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('Fallback: Botão Categorías clicado');

                    // Esconder todas as seções
                    document.querySelectorAll('.content-section').forEach(section => {
                        section.style.display = 'none';
                        section.classList.remove('active');
                    });

                    // Mostrar categorias
                    document.getElementById('categorias').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('categorias').classList.add('active');
                    }, 10);

                    // Atualizar botões
                    document.querySelectorAll('.btn-navigation-img').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Atualizar estado
                    window.location.hash = 'categorias';
                    localStorage.setItem('activeSection', 'categorias');
                });
            }

            // Verificación adicional: si estamos en la home sin parámetros,
            // forzar "Para Ti" si "Categorías" está activo
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.toString() && window.location.pathname === '/') {
                const categoriasActive = categoriasBtn && categoriasBtn.classList.contains('active');
                if (categoriasActive) {
                    console.log('Correção: Home sin filtros com Categorías ativo');
                    const sugerenciasBtn = document.querySelector('[data-target="sugerencias"]');
                    if (sugerenciasBtn) {
                        sugerenciasBtn.click();
                    }
                }
            }
        }, 1000);

    } catch (error) {
        console.error('Erro ao inicializar CategoriesManager:', error);
        setupSimpleFallback();
    }
});

// Función de fallback simple
function setupSimpleFallback() {
    console.log('Ativando fallback simples...');

    // Configurar botões
    document.querySelectorAll('.btn-navigation-img').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');

            // Esconder todas as seções
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });

            // Mostrar seção alvo
            const targetSection = document.getElementById(target);
            if (targetSection) {
                targetSection.style.display = 'block';
                setTimeout(() => {
                    targetSection.classList.add('active');
                }, 10);
            }

            // Atualizar botões
            document.querySelectorAll('.btn-navigation-img').forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');

            // Atualizar estado - SOLO guardar si no es la página principal
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.toString() && window.location.pathname === '/') {
                // En la página principal, siempre guardar "Para Ti"
                localStorage.setItem('activeSection', 'sugerencias');
            } else {
                window.location.hash = target;
                localStorage.setItem('activeSection', target);
            }
        });
    });

    // Configurar links de categoria
    document.querySelectorAll('.category-filter, .subcategory-filter').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category-id');

            // Ir para "Para Ti" primeiro
            const sugerenciasBtn = document.querySelector('[data-target="sugerencias"]');
            if (sugerenciasBtn) sugerenciasBtn.click();

            // Redirecionar com filtro
            setTimeout(() => {
                const url = new URL(window.location.origin + window.location.pathname);
                url.searchParams.set('category_id', categoryId);
                window.location.href = url.toString();
            }, 300);
        });
    });

    // Inicializar seção ativa
    const hash = window.location.hash.substring(1);
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('category_id')) {
        // Si hay filtro, mostrar "Para Ti"
        const sugerenciasBtn = document.querySelector('[data-target="sugerencias"]');
        if (sugerenciasBtn) sugerenciasBtn.click();
    } else if (hash === 'categorias' || hash === 'sugerencias') {
        const btn = document.querySelector(`[data-target="${hash}"]`);
        if (btn) btn.click();
    } else {
        // Por defecto, mostrar "Para Ti"
        const sugerenciasBtn = document.querySelector('[data-target="sugerencias"]');
        if (sugerenciasBtn) sugerenciasBtn.click();
    }
}

// FUNÇÕES GLOBAIS (para chamar de outros lugares)
window.switchToCategories = function() {
    console.log('switchToCategories() chamada');

    // Tentar usar o manager
    if (window.categoriesManager) {
        window.categoriesManager.switchSection('categorias', true);
        return true;
    }

    // Fallback: clicar no botão
    const categoriasBtn = document.querySelector('.btn-navigation-img[data-target="categorias"]');
    if (categoriasBtn) {
        categoriasBtn.click();
        return true;
    }

    // Fallback direto
    const categoriasSection = document.getElementById('categorias');
    const sugerenciasSection = document.getElementById('sugerencias');

    if (categoriasSection && sugerenciasSection) {
        sugerenciasSection.style.display = 'none';
        categoriasSection.style.display = 'block';

        document.querySelectorAll('.btn-navigation-img').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-target') === 'categorias') {
                btn.classList.add('active');
            }
        });

        return true;
    }

    console.error('Não foi possível alternar para categorias');
    return false;
};

window.switchToSuggestions = function() {
    console.log('switchToSuggestions() chamada');

    // Tentar usar o manager
    if (window.categoriesManager) {
        window.categoriesManager.switchSection('sugerencias', true);
        return true;
    }

    // Fallback: clicar no botão
    const sugerenciasBtn = document.querySelector('.btn-navigation-img[data-target="sugerencias"]');
    if (sugerenciasBtn) {
        sugerenciasBtn.click();
        return true;
    }

    return false;
};

// Función para resetear a "Para Ti" cuando se hace clic en el logo
window.resetToSuggestions = function() {
    console.log('Reseteando para "Para Ti"');
    localStorage.setItem('activeSection', 'sugerencias');
    window.switchToSuggestions();
};
