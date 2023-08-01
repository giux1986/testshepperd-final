<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        // Clear the existing order items table records (if any).
        OrderItem::truncate();

        // Insert fake order items using the factory.
        OrderItem::factory()->count(20)->create();
    }
}
