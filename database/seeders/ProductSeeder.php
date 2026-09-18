<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'store_id' => 1,
                'name' => 'لابتوب',
                'description' => 'وصف المنتج 1',
                'price' => 100.0,
            ],
            [
                'category_id' => 2,
                'store_id' => 1,
                'name' => 'هاتف ذكي',
                'description' => 'وصف المنتج 2',
                'price' => 200.0,
            ],
            [
                'category_id' => 3,
                'store_id' => 1,
                'name' => 'طاولة',
                'description' => 'وصف المنتج 3',
                'price' => 150.0,
            ],
        ];
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
