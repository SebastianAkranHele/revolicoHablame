<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;

class PublicController extends Controller
{
    // Página inicial
    public function index(Request $request)
    {
        // Query base dos anúncios ativos
        $query = Listing::with(['category', 'images'])
            ->where('status', 'active')
            ->latest();

        // Filtro de pesquisa
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filtro por categoria
        if ($request->has('category_id') && $request->category_id) {
            $categoryId = $request->category_id;

            // Buscar a categoria e suas subcategorías
            $category = Category::find($categoryId);
            $categoryIds = [$categoryId];

            // Se a categoria tem subcategorías, incluir também
            if ($category && $category->children->count() > 0) {
                $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
            }

            $query->whereIn('category_id', $categoryIds);
        }

        // Paginação
        $listings = $query->paginate(12);

        // Carregar todas as categorías ativas (principais y subcategorías)
        $categories = Category::with([
            'parent',
            'children' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('order')
                    ->orderBy('name');
            }
        ])
            ->withCount([
                'listings' => function ($q) {
                    $q->where('status', 'active');
                },
                'children' => function ($q) {
                    $q->where('is_active', true);
                }
            ])
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Para categorías principales, carregar contagem de anuncios de subcategorías
        foreach ($categories as $category) {
            // Se é categoria principal (sem parent_id), carregar informações das subcategorías
            if (is_null($category->parent_id)) {
                foreach ($category->children as $subcategory) {
                    $subcategory->loadCount([
                        'listings' => function ($q) {
                            $q->where('status', 'active');
                        }
                    ]);
                }
            }
        }

        // Se há filtro por categoría, carregar informação adicional
        $currentCategory = null;
        if ($request->has('category_id') && $request->category_id) {
            $currentCategory = Category::with('parent')
                ->withCount([
                    'listings' => function ($q) {
                        $q->where('status', 'active');
                    }
                ])
                ->find($request->category_id);
        }

        // Carregar categorías destacadas para la sección "Para Ti"
        $featuredCategories = Category::where('is_active', true)
            ->whereNull('parent_id') // Apenas categorías principais
            ->withCount([
                'listings' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->orderBy('order')
            ->orderBy('name')
            ->limit(8)
            ->get();

        return view('public.home', compact('listings', 'categories', 'currentCategory', 'featuredCategories'));
    }

    // Página de detalhes do anúncio
    public function show($slug)
    {
        // Busca o anúncio pelo slug, carregando categoria, usuário e imagens
        $listing = Listing::with(['category', 'user', 'images'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail(); // Retorna 404 se não encontrar

        // Busca anúncios similares:
        // - mesma categoria
        // - ativos
        // - exclui o próprio anúncio
        $similarListings = Listing::with(['images'])
            ->where('category_id', $listing->category_id)
            ->where('id', '!=', $listing->id)
            ->where('status', 'active')
            ->limit(4)
            ->latest()
            ->get();

        // Retorna para a view de detalhes
        return view('public.show', compact('listing', 'similarListings'));
    }
}
