<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Category;

class ListingController extends Controller
{
    /**
     * Listar todos os anúncios
     */
  public function index(Request $request)
{
    $query = Listing::with(['category', 'images']);

    // Filtro por status
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    // Filtro por categoria
    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Busca por título
    if ($request->has('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    $listings = $query->latest()->paginate(15);

    // Se quiser passar categorias para filtro
    $categories = Category::all();

    return view('admin.ads.index', compact('listings', 'categories'));
}

    /**
     * Mostrar formulário para criar novo anúncio
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.ads.create', compact('categories'));
    }

    /**
     * Salvar novo anúncio
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'image|max:4096'
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        $listing = Listing::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('listings', 'public');
                ListingImage::create(['listing_id' => $listing->id, 'path' => $path]);
            }
        }

        return redirect()->route('admin.ads.index')->with('success', 'Anúncio criado com sucesso');
    }

    /**
     * Mostrar formulário para editar anúncio existente
     */
    public function edit(Listing $listing)
    {
        $categories = Category::all();
        return view('admin.ads.edit', compact('listing', 'categories'));
    }
    /**
     * Mostrar detalhes de um anúncio
     */
    public function show(Listing $listing)
    {
        // Carregar relacionamentos
        $listing->load(['category', 'user', 'images']);

        return view('admin.ads.show', compact('listing'));
    }

    /**
     * Atualizar anúncio existente
     */
    public function update(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'image|max:4096'
        ]);

        $listing->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('listings', 'public');
                ListingImage::create(['listing_id' => $listing->id, 'path' => $path]);
            }
        }

        return redirect()->route('admin.ads.index')->with('success', 'Anúncio atualizado com sucesso');
    }

    /**
     * Remover anúncio
     */
    public function destroy(Listing $listing)
    {
        // Primeiro deleta as imagens físicas
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $listing->delete();
        return back()->with('success', 'Anúncio eliminado com sucesso');
    }

    /**
     * Remover imagem de um anúncio - VERSÃO CORRIGIDA
     */
    public function destroyImage($imageId)
{
    try {
        Log::info('=== INICIANDO DESTROY IMAGE AJAX ===');
        Log::info('Image ID recebido: ' . $imageId);

        // Verificar se é requisição AJAX
        $isAjax = request()->ajax() || request()->wantsJson() || request()->is('api/*');
        Log::info('É requisição AJAX? ' . ($isAjax ? 'Sim' : 'Não'));

        // Encontra a imagem
        $image = ListingImage::find($imageId);

        if (!$image) {
            Log::error('Imagem não encontrada ID: ' . $imageId);

            // Se for AJAX, retorna JSON
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagem não encontrada.'
                ], 404);
            }

            // Se não for AJAX, redireciona com erro
            return back()->with('error', 'Imagem não encontrada.');
        }

        Log::info('Imagem encontrada. Path: ' . $image->path);
        Log::info('Listing ID: ' . $image->listing_id);
        Log::info('User ID do anúncio: ' . $image->listing->user_id);
        Log::info('User atual: ' . auth()->id());
        Log::info('É admin: ' . (auth()->user()->is_admin ? 'Sim' : 'Não'));

        // Verificar se o usuário tem permissão
        if (!auth()->user()->is_admin && $image->listing->user_id !== auth()->id()) {
            Log::warning('Permissão negada para deletar imagem');

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não tem permissão para deletar esta imagem.'
                ], 403);
            }

            return back()->with('error', 'Não tem permissão para deletar esta imagem.');
        }

        // Apaga o arquivo da storage
        $filePath = 'public/' . $image->path;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            Log::info('Arquivo físico deletado: ' . $filePath);
        } else {
            Log::warning('Arquivo não existe na storage: ' . $filePath);
            // Verifica caminho alternativo
            $alternativePath = storage_path('app/public/' . $image->path);
            Log::info('Caminho alternativo: ' . $alternativePath);
            Log::info('Existe no caminho alternativo? ' . (file_exists($alternativePath) ? 'Sim' : 'Não'));
        }

        // Apenas apaga o registro da imagem
        $image->delete();
        Log::info('Registro da imagem deletado do banco de dados');

        // Se for AJAX, retorna JSON
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Imagem removida com sucesso!',
                'image_id' => $imageId
            ]);
        }

        // Se não for AJAX, redireciona normalmente
        return back()->with('success', 'Imagem removida com sucesso!');

    } catch (\Exception $e) {
        Log::error('ERRO ao deletar imagem: ' . $e->getMessage());
        Log::error($e->getTraceAsString());

        // Se for AJAX, retorna JSON com erro
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover imagem: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Erro ao remover imagem: ' . $e->getMessage());
    }
}
}
