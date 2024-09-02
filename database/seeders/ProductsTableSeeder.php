<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Coffee Blend 1', 'description' => 'A rich and aromatic blend for the perfect start to your day.', 'price' => 12.99, 'image' => 'coffee1.jpg'],
            ['name' => 'Coffee Blend 2', 'description' => 'Bold and smooth, ideal for those who like their coffee strong.', 'price' => 14.99, 'image' => 'coffee2.jpg'],
            ['name' => 'Coffee Blend 3', 'description' => 'Light and fruity, perfect for a refreshing coffee experience.', 'price' => 11.99, 'image' => 'coffee3.jpg'],
            ['name' => 'Coffee Blend 4', 'description' => 'Our premium blend with a touch of chocolate and caramel notes.', 'price' => 16.99, 'image' => 'coffee4.jpg'],
            ['name' => 'Coffee Blend 5', 'description' => 'A medium roast with hints of nuts and chocolate.', 'price' => 13.49, 'image' => 'coffee5.jpg'],
            ['name' => 'Coffee Blend 6', 'description' => 'Sweet and aromatic with a balanced flavor profile.', 'price' => 15.49, 'image' => 'coffee6.jpg'],
            ['name' => 'Coffee Blend 7', 'description' => 'Robust and full-bodied, perfect for a strong coffee fix.', 'price' => 17.99, 'image' => 'coffee7.jpg'],
            ['name' => 'Coffee Blend 8', 'description' => 'A smooth and creamy blend with a hint of vanilla.', 'price' => 18.99, 'image' => 'coffee8.jpg'],
        ]);
    }
}
