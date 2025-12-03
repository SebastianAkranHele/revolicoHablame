<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model {
    protected $fillable = [
        'user_id','category_id','title','slug','description',
        'price','location','phone','status'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function images() {
        return $this->hasMany(ListingImage::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}

