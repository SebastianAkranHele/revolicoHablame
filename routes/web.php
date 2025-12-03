<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes
Route::get('/', [PublicController::class,'index'])->name('home');
Route::get('/anuncio/{slug}', [PublicController::class,'show'])->name('public.show');

// Auth routes (Breeze already provides /login /logout)
require __DIR__.'/auth.php';

// Admin routes
Route::prefix('admin')->middleware(['auth','admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rota AJAX para deletar imagens - com nome único
    Route::delete('ajax/delete-image/{image}', [AdminListingController::class, 'destroyImage'])
        ->name('ajax.delete.image');

    // Recursos admin
    Route::resource('ads', AdminListingController::class)->parameters(['ads'=>'listing']);

    // Rotas para categorias
    Route::prefix('categories')->group(function () {
        // Rotas CRUD básicas
        Route::get('/', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Rotas adicionais para funcionalidades extras
        Route::post('/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::post('/reorder', [AdminCategoryController::class, 'reorder'])->name('categories.reorder');
        Route::post('/{category}/duplicate', [AdminCategoryController::class, 'duplicate'])->name('categories.duplicate');
        Route::get('/export', [AdminCategoryController::class, 'export'])->name('categories.export');
        Route::get('/search', [AdminCategoryController::class, 'search'])->name('categories.search');
        Route::get('/{category}/subcategories', [AdminCategoryController::class, 'getSubcategories'])->name('categories.subcategories');
        Route::post('/bulk-status', [AdminCategoryController::class, 'bulkStatus'])->name('categories.bulk-status');
        Route::post('/bulk-delete', [AdminCategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
        Route::get('/categories/generate-slug', [AdminCategoryController::class, 'generateSlug'])->name('categories.generate-slug');
    });
});
