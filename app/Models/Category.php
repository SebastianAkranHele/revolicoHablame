<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color', // Adicionado
        'description',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true,
        'order' => 0,
        'color' => '#6C4DFF', // Adicionado
        'icon' => 'box' // Adicionado
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    protected $appends = [
        'active_listings_count',
        'color_code', // Adicionado para fallback de cor
        'full_icon', // Adicionado para ícone completo
        'is_main_category', // Adicionado para fácil acesso
        'is_sub_category' // Adicionado para fácil acesso
    ];

    // Relação com a categoria pai
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relação com subcategorías
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('order')
            ->orderBy('name');
    }

    // Relação com anúncios ativos
    public function activeListings()
    {
        return $this->hasMany(Listing::class)->where('status', 'active');
    }

    // Relação com anúncios
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    // Acesso para obter todas as subcategorías recursivamente
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Verifica se é uma categoria principal (sem pai)
    public function getIsMainCategoryAttribute()
    {
        return is_null($this->parent_id);
    }

    // Verifica se é uma subcategoria
    public function getIsSubCategoryAttribute()
    {
        return !is_null($this->parent_id);
    }

    // Obtém o caminho completo da categoria (pai > filho)
    public function getFullPathAttribute()
    {
        $path = $this->name;

        if ($this->parent) {
            $path = $this->parent->name . ' > ' . $path;
        }

        return $path;
    }

    // Obtém a contagem de anúncios ativos
    public function getActiveListingsCountAttribute()
    {
        if (isset($this->listings_count)) {
            return $this->listings_count;
        }

        return $this->listings()->where('status', 'active')->count();
    }

    // Obtém a cor baseada no ícone (fallback)
    public function getColorCodeAttribute()
    {
        // Se já tem cor definida, usa ela
        if ($this->color && $this->color !== '#6C4DFF') {
            return $this->color;
        }

        // Fallback: cor baseada no ícone
        $iconColors = [
            'tv' => '#4361ee',
            'phone' => '#3a0ca3',
            'laptop' => '#7209b7',
            'tablet' => '#560bad',
            'smartwatch' => '#480ca8',
            'car-front' => '#f72585',
            'bicycle' => '#b5179e',
            'motorcycle' => '#7209b7',
            'truck' => '#560bad',
            'house-door' => '#4cc9f0',
            'building' => '#4895ef',
            'geo-alt' => '#4361ee',
            'house' => '#3a0ca3',
            'building-fill' => '#3a0ca3',
            'tools' => '#ff9e00',
            'wrench' => '#ff9100',
            'hammer' => '#ff8500',
            'screwdriver' => '#ff7900',
            'gear' => '#ff6d00',
            'person' => '#06d6a0',
            'person-circle' => '#05c997',
            'people' => '#04b48d',
            'person-badge' => '#03a084',
            'book' => '#118ab2',
            'journal' => '#0d7da3',
            'pencil' => '#0a7095',
            'bookmark' => '#076386',
            'shirt' => '#ef476f',
            'handbag' => '#ec3d68',
            'watch' => '#ea3462',
            'eyeglasses' => '#e72a5b',
            'cart' => '#9d4edd',
            'cart2' => '#9245d6',
            'cart3' => '#863dcf',
            'cart4' => '#7b34c8',
            'bag' => '#6f2cc1',
            'music-note' => '#ff6d00',
            'music-note-beamed' => '#ff6b00',
            'music-player' => '#ff6900',
            'headphones' => '#ff6700',
            'controller' => '#ff6d00',
            'joystick' => '#ff6b00',
            'dice-5' => '#ff6900',
            'disc' => '#ff6700',
            'cup' => '#ff9e00',
            'cup-straw' => '#ff9c00',
            'egg-fried' => '#ff9a00',
            'egg' => '#ff9800',
            'flower1' => '#4caf50',
            'tree' => '#43a047',
            'leaf' => '#388e3c',
            'flower2' => '#2e7d32',
            'heart' => '#e63946',
            'heart-fill' => '#d32f2f',
            'star' => '#ffd600',
            'star-fill' => '#ffc107',
            'box' => '#6C4DFF',
            'box-seam' => '#6344e6',
            'bucket' => '#5a3ccc',
            'briefcase' => '#5135b3',
            'cpu' => '#4361ee',
            'motherboard' => '#3a56d4',
            'device-ssd' => '#314cbb',
            'router' => '#2841a1',
            'palette' => '#ff6d00',
            'brush' => '#ff6b00',
            'image' => '#ff6900',
            'camera' => '#ff6700',
            'balloon' => '#9d4edd',
            'gift' => '#9245d6',
            'balloon-heart' => '#863dcf',
            'gem' => '#7b34c8'
        ];

        return $iconColors[$this->icon] ?? '#6C4DFF';
    }

    // Obtém ícone completo com prefixo bi-
    public function getFullIconAttribute()
    {
        return 'bi-' . ($this->icon ?: 'box');
    }

    // Obtém todas as categorías principais
    public static function getMainCategories()
    {
        return self::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->orderBy('order')->orderBy('name');
            }])
            ->orderBy('order')
            ->orderBy('name')
            ->get();
    }

    // Obtém todas as categorías ativas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Obtém categorías por ordem
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Obtém categorías principais
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    // Obtém subcategorías
    public function scopeSub($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Obtém categorías com anúncios
    public function scopeHasListings($query)
    {
        return $query->whereHas('listings', function($q) {
            $q->where('status', 'active');
        });
    }

    // Busca por nome ou slug
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    // Busca por categoria e subcategorías
    public function scopeWithAllChildren($query)
    {
        return $query->with(['children' => function($q) {
            $q->withCount(['listings' => function($q2) {
                $q2->where('status', 'active');
            }])
            ->orderBy('order')
            ->orderBy('name');
        }])
        ->withCount(['listings' => function($q) {
            $q->where('status', 'active');
        }])
        ->orderBy('order')
        ->orderBy('name');
    }

    // Verifica se a categoria tem filhos
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    // Verifica se a categoria tem anúncios ativos
    public function hasActiveListings()
    {
        return $this->activeListings()->count() > 0;
    }

    // Obtém a hierarquia completa
    public function getHierarchyAttribute()
    {
        $hierarchy = [];

        if ($this->parent) {
            $hierarchy[] = $this->parent;
            if ($this->parent->parent) {
                array_unshift($hierarchy, $this->parent->parent);
            }
        }

        return $hierarchy;
    }

    // Gera slug automático se não for fornecido
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }

    // Método para obter todas as categorías em formato para select
    public static function getForSelect()
    {
        $categories = self::main()
            ->with(['children' => function($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $result = [];

        foreach ($categories as $category) {
            $result[$category->id] = $category->name;

            foreach ($category->children as $child) {
                $result[$child->id] = '-- ' . $child->name;
            }
        }

        return $result;
    }

    // Método para obter IDs de todas as subcategorías
    public function getAllChildrenIds()
    {
        $ids = $this->children->pluck('id')->toArray();

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }

        return $ids;
    }

    // Método para verificar se é descendente de outra categoria
    public function isDescendantOf($categoryId)
    {
        if ($this->parent_id === $categoryId) {
            return true;
        }

        if ($this->parent) {
            return $this->parent->isDescendantOf($categoryId);
        }

        return false;
    }
}
