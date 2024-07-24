<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'brand' => $this->faker->company,
            'official_price' => $this->faker->randomFloat(2, 10, 1000),
            'sale_price' => $this->faker->randomFloat(2, 10, 1000),
            'image' => 'demo.jpg', // 默認的圖片
        ];
    }
}