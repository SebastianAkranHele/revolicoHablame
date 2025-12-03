<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true,
        'order' => 0,
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
    public function isMainCategory()
    {
        return is_null($this->parent_id);
    }

    // Verifica se é uma subcategoria
    public function isSubCategory()
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

    // Obtém todas as categorías principais
    public static function getMainCategories()
    {
        return self::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->orderBy('name')
            ->get();
    }

    // Obtém a contagem de anúncios ativos
    public function getActiveListingsCountAttribute()
    {
        return $this->listings()->where('status', 'active')->count();
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

    // Busca por nome ou slug
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%");
    }
}
