<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'sku' => 'produk-sku',
            'type' => 'configurable',
            'name' => 'nama produk',
            'slug' => 'nama-produk',
            'user_id' => 1
        ]);
        Product::create([
            'sku' => 'product-sku-simple',
            'type' => 'simple',
            'name' => 'nama produk simple',
            'slug' => 'nama-produk-simple',
            'user_id' => 1
        ]);
    }
}
