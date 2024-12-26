<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr; // Import Arr helper

class FlowerSeeder extends Seeder
{
    public function run()
    {
        $flowers = [
            // Existing flower entries
            [
                'name' => 'SYMP23-H',
                'category' => 'FUNERAL',
                'price' => 2500.00,
                'rating' => 5,
                'image_path' => 'storage/images/flower1.jpg',
                'description' => 'Beautiful funeral flower arrangement, designed with sympathy and elegance in mind.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add other predefined entries here...
        ];
    
        // Categories to randomize
        $categories = ['FUNERAL', 'BOUQUET', 'INAUGURAL', 'ARRANGEMENTS', 'FRUITS AND FLOWERS'];
    
        // Generate 20 random flowers
        for ($i = 1; $i <= 20; $i++) {
            $flowers[] = [
                'name' => 'Flower ' . $i,
                'category' => Arr::random($categories),
                'price' => rand(1000, 6000), // Random price
                'rating' => rand(3, 5),
                'image_path' => 'storage/images/flower1.jpg',
                'description' => 'Description for flower ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Insert all flower data into the table
        DB::table('flowers')->insert($flowers);
    }
}
