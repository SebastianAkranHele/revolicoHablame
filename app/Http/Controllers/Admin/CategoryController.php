<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent', 'children', 'listings'])
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15);

        $mainCategories = Category::whereNull('parent_id')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories', 'mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Ícones disponíveis do Bootstrap Icons
        $icons = [
            'tv', 'phone', 'laptop', 'tablet', 'smartwatch',
            'car-front', 'bicycle', 'motorcycle', 'truck',
            'house-door', 'building', 'geo-alt', 'house', 'building-fill',
            'tools', 'wrench', 'hammer', 'screwdriver', 'gear',
            'person', 'person-circle', 'people', 'person-badge',
            'book', 'journal', 'pencil', 'bookmark',
            'shirt', 'handbag', 'watch', 'eyeglasses',
            'cart', 'cart2', 'cart3', 'cart4', 'bag',
            'music-note', 'music-note-beamed', 'music-player', 'headphones',
            'controller', 'joystick', 'dice-5', 'disc',
            'cup', 'cup-straw', 'egg-fried', 'egg',
            'flower1', 'tree', 'leaf', 'flower2',
            'heart', 'heart-fill', 'star', 'star-fill',
            'box', 'box-seam', 'bucket', 'briefcase',
            'cpu', 'motherboard', 'device-ssd', 'router',
            'palette', 'brush', 'image', 'camera',
            'balloon', 'gift', 'balloon-heart', 'gem'
        ];

        return view('admin.categories.create', compact('categories', 'icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Gerar slug automaticamente
        $data['slug'] = Str::slug($data['name']);

        // Definir valores padrão
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['icon'] = $data['icon'] ?? 'box';
        $data['order'] = $data['order'] ?? $this->getNextOrder($data['parent_id'] ?? null);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Ícones disponíveis do Bootstrap Icons
        $icons = [
            'tv', 'phone', 'laptop', 'tablet', 'smartwatch',
            'car-front', 'bicycle', 'motorcycle', 'truck',
            'house-door', 'building', 'geo-alt', 'house', 'building-fill',
            'tools', 'wrench', 'hammer', 'screwdriver', 'gear',
            'person', 'person-circle', 'people', 'person-badge',
            'book', 'journal', 'pencil', 'bookmark',
            'shirt', 'handbag', 'watch', 'eyeglasses',
            'cart', 'cart2', 'cart3', 'cart4', 'bag',
            'music-note', 'music-note-beamed', 'music-player', 'headphones',
            'controller', 'joystick', 'dice-5', 'disc',
            'cup', 'cup-straw', 'egg-fried', 'egg',
            'flower1', 'tree', 'leaf', 'flower2',
            'heart', 'heart-fill', 'star', 'star-fill',
            'box', 'box-seam', 'bucket', 'briefcase',
            'cpu', 'motherboard', 'device-ssd', 'router',
            'palette', 'brush', 'image', 'camera',
            'balloon', 'gift', 'balloon-heart', 'gem'
        ];

        return view('admin.categories.edit', compact('category', 'categories', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Verificar se está tentando tornar a categoria pai dela mesma
        if ($data['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Uma categoria não pode ser pai de si mesma.'])
                ->withInput();
        }

        // Verificar ciclos (uma categoria não pode ser filha de sua própria filha)
        if ($this->hasCycle($category, $data['parent_id'])) {
            return back()->withErrors(['parent_id' => 'Essa configuração criaria um ciclo na hierarquia de categorias.'])
                ->withInput();
        }

        // Gerar novo slug se o nome foi alterado
        if ($data['name'] !== $category->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Definir valores booleanos
        $data['is_active'] = $request->has('is_active') ? true : false;

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Verifica se existe algum listing nessa categoria
        if ($category->listings()->count() > 0) {
            return back()->with('error', 'Não é possível deletar uma categoria que possui anúncios.');
        }

        // Verifica se tem subcategorias
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Não é possível deletar uma categoria que possui subcategorias. Remova as subcategorias primeiro.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoria eliminada com sucesso.');
    }

    /**
     * Toggle status da categoria
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'ativada' : 'desativada';
        return back()->with('success', "Categoria {$status} com sucesso.");
    }

    /**
     * Reordenar categorias via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        foreach ($request->ids as $index => $id) {
            Category::where('id', $id)->update([
                'order' => $index + 1,
                'parent_id' => $request->parent_id
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Buscar categorias para autocomplete
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        $categories = Category::where('name', 'like', "%{$search}%")
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'icon']);

        return response()->json($categories);
    }

    /**
     * Obter subcategorias de uma categoria
     */
    public function getSubcategories(Category $category)
    {
        $subcategories = $category->children()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get(['id', 'name', 'icon']);

        return response()->json($subcategories);
    }

    /**
     * Duplicar categoria
     */
    public function duplicate(Category $category)
    {
        $newCategory = $category->replicate();
        $newCategory->name = $category->name . ' (Cópia)';
        $newCategory->slug = $category->slug . '-copia-' . time();
        $newCategory->order = $this->getNextOrder($category->parent_id);
        $newCategory->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria duplicada com sucesso.');
    }

    /**
     * Exportar categorias para CSV
     */
    public function export()
    {
        $categories = Category::with(['parent', 'listings'])
            ->orderBy('parent_id')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $filename = "categorias_" . date('Y-m-d_H-i-s') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Cabeçalho com BOM para Excel
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'ID',
            'Nome',
            'Slug',
            'Categoria Pai',
            'Ícone',
            'Descrição',
            'Ordem',
            'Status',
            'Total Anúncios',
            'Data Criação'
        ], ';');

        // Dados
        foreach ($categories as $category) {
            fputcsv($output, [
                $category->id,
                $category->name,
                $category->slug,
                $category->parent ? $category->parent->name : '-',
                $category->icon,
                substr($category->description ?? '', 0, 100),
                $category->order,
                $category->is_active ? 'Ativa' : 'Inativa',
                $category->listings->count(),
                $category->created_at->format('d/m/Y H:i')
            ], ';');
        }

        fclose($output);
        exit;
    }

    /**
     * Helper para obter próxima ordem
     */
    private function getNextOrder($parentId = null)
    {
        $maxOrder = Category::where('parent_id', $parentId)
            ->max('order');

        return ($maxOrder ?? 0) + 1;
    }

    /**
     * Verificar se há ciclo na hierarquia
     */
    private function hasCycle($category, $newParentId)
    {
        if (!$newParentId) {
            return false;
        }

        // Obter todos os descendentes da categoria atual
        $descendantIds = $this->getAllDescendantIds($category);

        // Se o novo pai está entre os descendentes, temos um ciclo
        return in_array($newParentId, $descendantIds);
    }

    /**
     * Obter todos os IDs descendentes
     */
    private function getAllDescendantIds($category)
    {
        $descendantIds = [];

        foreach ($category->children as $child) {
            $descendantIds[] = $child->id;
            $descendantIds = array_merge($descendantIds, $this->getAllDescendantIds($child));
        }

        return $descendantIds;
    }

    /**
     * Alterar status em massa
     */
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
            'status' => 'required|boolean'
        ]);

        Category::whereIn('id', $request->ids)
            ->update(['is_active' => $request->status]);

        $statusText = $request->status ? 'ativadas' : 'desativadas';
        $count = count($request->ids);

        return response()->json([
            'success' => true,
            'message' => "{$count} categorias {$statusText} com sucesso!"
        ]);
    }

    /**
     * Excluir em massa
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        $errors = [];
        $successCount = 0;

        foreach ($request->ids as $id) {
            $category = Category::find($id);

            // Verificar se pode ser excluída
            if ($category->listings()->count() > 0) {
                $errors[] = "A categoria '{$category->name}' possui anúncios e não pode ser excluída.";
                continue;
            }

            if ($category->children()->count() > 0) {
                $errors[] = "A categoria '{$category->name}' possui subcategorias e não pode ser excluída.";
                continue;
            }

            $category->delete();
            $successCount++;
        }

        $response = [
            'success' => true,
            'message' => "{$successCount} categorias excluídas com sucesso."
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response);
    }
    public function generateSlug(Request $request)
{
    $text = $request->get('text');

    if (!$text) {
        return response()->json(['error' => 'Texto é obrigatório'], 400);
    }

    $slug = Str::slug($text);
    return response()->json(['slug' => $slug]);
}
}
