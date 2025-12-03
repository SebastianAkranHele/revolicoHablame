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
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Filtro por categoria
    if ($request->has('category_id') && $request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    // Paginação
    $listings = $query->paginate(12);

    // Todas as categorías com subcategorías e contagem de anúncios
    $categories = Category::with(['children' => function($query) {
            $query->orderBy('name');
        }])
        ->withCount(['listings' => function($q) {
            $q->where('status', 'active');
        }])
        ->whereNull('parent_id') // Apenas categorías principais
        ->orderBy('name')
        ->get();

    // Carregar também contagem para subcategorías
    foreach ($categories as $category) {
        foreach ($category->children as $subcategory) {
            $subcategory->loadCount(['listings' => function($q) {
                $q->where('status', 'active');
            }]);
        }
    }

    return view('public.home', compact('listings', 'categories'));
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
