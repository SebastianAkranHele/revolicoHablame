<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use App\Models\ListingImage;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        foreach (range(1, 20) as $i) {

            $title = fake()->sentence(4);

            $listing = Listing::create([
                'user_id'     => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title'       => $title,
                'slug'        => Str::slug($title) . '-' . $i,
                'description' => fake()->paragraph(5),
                'price'       => fake()->randomFloat(2, 20, 2000),
                'location'    => fake()->city(),
                'phone'       => fake()->phoneNumber(),
                'status'      => 'active'
            ]);

            // Criar imagens falsas
            foreach (range(1, rand(1, 4)) as $img) {
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'path' => 'uploads/listings/dummy' . rand(1,5) . '.jpg',
                ]);
            }
        }
    }
}
