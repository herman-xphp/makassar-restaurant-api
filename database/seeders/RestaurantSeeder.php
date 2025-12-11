<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Real Makassar restaurants with approximate coordinates
        $restaurants = [
            [
                'name' => 'Sop Saudara',
                'description' => 'Famous for its delicious seafood soup and traditional Makassar cuisine',
                'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
                'latitude' => -5.147754,
                'longitude' => 119.432711,
                'phone' => '+62411-361234',
                'cuisine_type' => 'Seafood, Traditional',
                'rating' => 4.5,
                'review_count' => 245,
                'image_url' => 'https://example.com/images/sop-saudara.jpg'
            ],
            [
                'name' => 'Rumah Makan Sari Laut',
                'description' => 'Authentic Makassar seafood restaurant with fresh catch of the day',
                'address' => 'Jl. Pantai Losari, Makassar',
                'latitude' => -5.156589,
                'longitude' => 119.411140,
                'phone' => '+62411-362345',
                'cuisine_type' => 'Seafood',
                'rating' => 4.3,
                'review_count' => 189,
                'image_url' => 'https://example.com/images/sari-laut.jpg'
            ],
            [
                'name' => 'Coto Makassar Karebosi',
                'description' => 'Traditional Coto Makassar soup with authentic recipe',
                'address' => 'Jl. Jenderal Sudirman No. 10, Makassar',
                'latitude' => -5.142940,
                'longitude' => 119.410647,
                'phone' => '+62411-363456',
                'cuisine_type' => 'Traditional, Coto',
                'rating' => 4.2,
                'review_count' => 312,
                'image_url' => 'https://example.com/images/coto-karebosi.jpg'
            ],
            [
                'name' => 'Sate Matangkaluku',
                'description' => 'Best grilled meat skewers with traditional spices from South Sulawesi',
                'address' => 'Jl. AP. Pettarani, Makassar',
                'latitude' => -5.135345,
                'longitude' => 119.428705,
                'phone' => '+62411-364567',
                'cuisine_type' => 'Grill, Sate',
                'rating' => 4.4,
                'review_count' => 278,
                'image_url' => 'https://example.com/images/sate-matangkaluku.jpg'
            ],
            [
                'name' => 'Mie Kering Pak Min',
                'description' => 'Popular traditional Makassar dried noodles with crispy topping',
                'address' => 'Jl. Malengkeri Raya No. 24, Makassar',
                'latitude' => -5.125373,
                'longitude' => 119.423757,
                'phone' => '+62411-365678',
                'cuisine_type' => 'Noodles',
                'rating' => 4.1,
                'review_count' => 156,
                'image_url' => 'https://example.com/images/mie-kering.jpg'
            ],
            [
                'name' => 'Kedai Kopi Toraja',
                'description' => 'Premium Toraja coffee with traditional Makassar snacks',
                'address' => 'Jl. Boulevard, Panakkukang, Makassar',
                'latitude' => -5.147077,
                'longitude' => 119.427842,
                'phone' => '+62411-366789',
                'cuisine_type' => 'Coffee, Snacks',
                'rating' => 4.6,
                'review_count' => 421,
                'image_url' => 'https://example.com/images/kopi-toraja.jpg'
            ],
            [
                'name' => 'Rujak Cingur Makassar',
                'description' => 'Authentic Makassar-style rujak with traditional sauce',
                'address' => 'Jl. Urip Sumoharjo No. 112, Makassar',
                'latitude' => -5.152763,
                'longitude' => 119.418614,
                'phone' => '+62411-367890',
                'cuisine_type' => 'Fruits, Traditional',
                'rating' => 4.0,
                'review_count' => 198,
                'image_url' => 'https://example.com/images/rujak-cingur.jpg'
            ],
            [
                'name' => 'Pisang Epe Appi',
                'description' => 'Famous grilled bananas with palm sugar and grated coconut',
                'address' => 'Pantai Appi, Biringkanaya, Makassar',
                'latitude' => -5.109621,
                'longitude' => 119.463691,
                'phone' => '+62411-368901',
                'cuisine_type' => 'Dessert',
                'rating' => 4.7,
                'review_count' => 287,
                'image_url' => 'https://example.com/images/pisang-epe.jpg'
            ],
            [
                'name' => 'Sop Konro Karebosi',
                'description' => 'Authentic Konro (ribs soup) from South Sulawesi',
                'address' => 'Jl. Jenderal Sudirman No. 15, Makassar',
                'latitude' => -5.143220,
                'longitude' => 119.410987,
                'phone' => '+62411-369012',
                'cuisine_type' => 'Soup, Traditional',
                'rating' => 4.3,
                'review_count' => 342,
                'image_url' => 'https://example.com/images/sop-konro.jpg'
            ],
            [
                'name' => 'Martabak Bangka Makassar',
                'description' => 'Delicious sweet and savory martabak with various fillings',
                'address' => 'Jl. Sultan Alauddin No. 45, Makassar',
                'latitude' => -5.175939,
                'longitude' => 119.423682,
                'phone' => '+62411-370123',
                'cuisine_type' => 'Dessert, Snacks',
                'rating' => 4.2,
                'review_count' => 256,
                'image_url' => 'https://example.com/images/martabak-bangka.jpg'
            ]
        ];

        foreach ($restaurants as $restaurantData) {
            Restaurant::create($restaurantData);
        }
    }
}
