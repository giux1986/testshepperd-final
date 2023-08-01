<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Clear the existing orders table records (if any).
        DB::table('orders')->truncate();

        // Insert fake orders using the factory.
        Order::factory()->count(5)->create();
    }
}
