<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Clear the existing products table records (if any).
        DB::table('products')->truncate();

        // Insert fake products using the factory.
        Product::factory()->count(10)->create();
    }
}
