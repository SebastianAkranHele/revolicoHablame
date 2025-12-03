<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Categorías principais com ícones
        $mainCategories = [
            [
                'name' => 'Eletrônicos',
                'slug' => 'eletronicos',
                'icon' => 'tv',
                'description' => 'Smartphones, computadores, tablets, TVs e outros equipamentos eletrónicos',
                'sort_order' => 1,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Veículos',
                'slug' => 'veiculos',
                'icon' => 'car-front',
                'description' => 'Carros, motos, bicicletas, peças e acessórios para veículos',
                'sort_order' => 2,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Imóveis',
                'slug' => 'imoveis',
                'icon' => 'house-door',
                'description' => 'Casas, apartamentos, terrenos, imóveis comerciais para venda ou aluguel',
                'sort_order' => 3,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Telefones',
                'slug' => 'telefones',
                'icon' => 'phone',
                'description' => 'Smartphones, celulares, acessórios para telefones',
                'sort_order' => 4,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Computadores',
                'slug' => 'computadores',
                'icon' => 'laptop',
                'description' => 'Notebooks, desktops, componentes, periféricos e acessórios',
                'sort_order' => 5,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Roupas',
                'slug' => 'roupas',
                'icon' => 'tshirt',
                'description' => 'Roupas, calçados, acessórios de moda para homens, mulheres e crianças',
                'sort_order' => 6,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Móveis',
                'slug' => 'moveis',
                'icon' => 'couch',
                'description' => 'Móveis para casa, escritório, decoração e jardim',
                'sort_order' => 7,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Serviços',
                'slug' => 'servicos',
                'icon' => 'tools',
                'description' => 'Prestação de serviços diversos, profissionais autónomos',
                'sort_order' => 8,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Emprego',
                'slug' => 'emprego',
                'icon' => 'briefcase',
                'description' => 'Ofertas de emprego, estágios, trabalhos temporários',
                'sort_order' => 9,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Animais',
                'slug' => 'animais',
                'icon' => 'heart',
                'description' => 'Animais de estimação, acessórios, ração e serviços veterinários',
                'sort_order' => 10,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Esportes',
                'slug' => 'esportes',
                'icon' => 'bicycle',
                'description' => 'Equipamentos esportivos, bicicletas, artigos para fitness',
                'sort_order' => 11,
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'Livros',
                'slug' => 'livros',
                'icon' => 'book',
                'description' => 'Livros, revistas, quadrinhos, materiais didáticos',
                'sort_order' => 12,
                'parent_id' => null,
                'is_active' => true
            ]
        ];

        // Limpa a tabela se estiver vazia
        if (Category::count() === 0) {
            foreach ($mainCategories as $category) {
                Category::create($category);
            }

            $this->command->info(count($mainCategories) . ' categorías principais criadas!');
        } else {
            // Atualiza as categorías existentes com novos campos
            foreach ($mainCategories as $categoryData) {
                $category = Category::where('slug', $categoryData['slug'])->first();

                if ($category) {
                    // Atualiza apenas os campos que estão vazios ou são diferentes
                    $category->update([
                        'icon' => $categoryData['icon'],
                        'description' => $category->description ?? $categoryData['description'],
                        'sort_order' => $categoryData['sort_order'],
                        'is_active' => true
                    ]);
                } else {
                    // Cria nova categoria se não existir
                    Category::create($categoryData);
                }
            }

            $this->command->info('Categorías atualizadas com novos campos!');
        }

        // Cria algumas subcategorías de exemplo (opcional)
        $this->createSubcategories();
    }

    private function createSubcategories()
    {
        // Encontra algumas categorías principais para criar subcategorías
        $electronics = Category::where('slug', 'eletronicos')->first();
        $vehicles = Category::where('slug', 'veiculos')->first();
        $properties = Category::where('slug', 'imoveis')->first();

        if ($electronics) {
            $electronicsSubcategories = [
                [
                    'name' => 'Smartphones',
                    'slug' => 'smartphones',
                    'icon' => 'phone',
                    'description' => 'Celulares, smartphones e acessórios',
                    'sort_order' => 1,
                    'parent_id' => $electronics->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Computadores',
                    'slug' => 'computadores-eletronicos',
                    'icon' => 'laptop',
                    'description' => 'Notebooks, desktops e componentes',
                    'sort_order' => 2,
                    'parent_id' => $electronics->id,
                    'is_active' => true
                ],
                [
                    'name' => 'TVs e Áudio',
                    'slug' => 'tvs-audio',
                    'icon' => 'tv',
                    'description' => 'Televisores, sistemas de som, home theater',
                    'sort_order' => 3,
                    'parent_id' => $electronics->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Câmeras',
                    'slug' => 'cameras',
                    'icon' => 'camera',
                    'description' => 'Câmeras fotográficas, filmadoras e acessórios',
                    'sort_order' => 4,
                    'parent_id' => $electronics->id,
                    'is_active' => true
                ]
            ];

            foreach ($electronicsSubcategories as $subcategory) {
                if (!Category::where('slug', $subcategory['slug'])->exists()) {
                    Category::create($subcategory);
                }
            }

            $this->command->info('Subcategorías de Eletrónicos criadas!');
        }

        if ($vehicles) {
            $vehiclesSubcategories = [
                [
                    'name' => 'Carros',
                    'slug' => 'carros',
                    'icon' => 'car-front',
                    'description' => 'Carros usados e novos',
                    'sort_order' => 1,
                    'parent_id' => $vehicles->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Motos',
                    'slug' => 'motos',
                    'icon' => 'bicycle',
                    'description' => 'Motocicletas, scooters',
                    'sort_order' => 2,
                    'parent_id' => $vehicles->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Peças',
                    'slug' => 'pecas-veiculos',
                    'icon' => 'gear',
                    'description' => 'Peças e acessórios para veículos',
                    'sort_order' => 3,
                    'parent_id' => $vehicles->id,
                    'is_active' => true
                ]
            ];

            foreach ($vehiclesSubcategories as $subcategory) {
                if (!Category::where('slug', $subcategory['slug'])->exists()) {
                    Category::create($subcategory);
                }
            }

            $this->command->info('Subcategorías de Veículos criadas!');
        }

        if ($properties) {
            $propertiesSubcategories = [
                [
                    'name' => 'Casas',
                    'slug' => 'casas',
                    'icon' => 'house',
                    'description' => 'Casas para venda ou aluguel',
                    'sort_order' => 1,
                    'parent_id' => $properties->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Apartamentos',
                    'slug' => 'apartamentos',
                    'icon' => 'building',
                    'description' => 'Apartamentos para venda ou aluguel',
                    'sort_order' => 2,
                    'parent_id' => $properties->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Terrenos',
                    'slug' => 'terrenos',
                    'icon' => 'geo-alt',
                    'description' => 'Terrenos e lotes',
                    'sort_order' => 3,
                    'parent_id' => $properties->id,
                    'is_active' => true
                ],
                [
                    'name' => 'Comercial',
                    'slug' => 'comercial',
                    'icon' => 'shop',
                    'description' => 'Imóveis comerciais',
                    'sort_order' => 4,
                    'parent_id' => $properties->id,
                    'is_active' => true
                ]
            ];

            foreach ($propertiesSubcategories as $subcategory) {
                if (!Category::where('slug', $subcategory['slug'])->exists()) {
                    Category::create($subcategory);
                }
            }

            $this->command->info('Subcategorías de Imóveis criadas!');
        }
    }
}
