<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 5), // Assuming you have 5 fake orders created earlier.
            'product_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 fake products.
            'qty' => $this->faker->numberBetween(1, 5),
            'item_price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
