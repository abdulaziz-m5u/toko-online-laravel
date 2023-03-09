<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => 1,
            'name' => 'pakaian',
            'slug' => 'pakaian',
            'parent_id' => null
        ]);
        Category::create([
            'id' => 2,
            'name' => 'pakaian laki-laki',
            'slug' => 'pakaian-laki-laki',
            'parent_id' => 1
        ]);
        Category::create([
            'id' => 3,
            'name' => 'pakaian perempuan',
            'slug' => 'pakaian-perempuan',
            'parent_id' => 1
        ]);
    }
}
