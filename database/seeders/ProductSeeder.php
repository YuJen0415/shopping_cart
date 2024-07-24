<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $rawProducts = DB::table('products')->get();

        foreach ($rawProducts as $rawProduct) {
            Product::create([
                'name' => $rawProduct->name,
                'brand' => $rawProduct->brand,
                'official_price' => $rawProduct->official_price,
                'sale_price' => $rawProduct->sale_price,
                'image' => $rawProduct->image ?? 'demo.jpg',
            ]);
        }
    }
}