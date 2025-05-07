<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Chippy BBQ',
            'description' => 'Masarap at malutong!',
            'category' => 'snacks',
            'price' => 15.00,
            'image' => 'chippy.jpg',
        ]);
    }
}
