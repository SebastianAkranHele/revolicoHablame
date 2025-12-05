<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Contadores gerais
        $listingsCount = Listing::count();
        $categoriesCount = Category::count();
        $usersCount = User::count();

        // Últimos anúncios
        $recentListings = Listing::with('category', 'images')->latest()->take(6)->get();

        // Últimos usuários
        $recentUsers = User::latest()->take(5)->get();

        // Dados do gráfico: anúncios por mês (últimos 6 meses)
        $listingStats = Listing::select(
            DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month"),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('admin.dashboard', compact(
            'listingsCount', 'categoriesCount', 'usersCount', 'recentListings', 'recentUsers', 'listingStats'
        ));
    }
}
