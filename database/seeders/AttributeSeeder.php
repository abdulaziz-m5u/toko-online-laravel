<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $AttributeColor = Attribute::create([
            'id' => 1,
            'code' => 'color',
            'name' => 'color',
            'type' => 'select'
        ]);
        $AttributeSize = Attribute::create([
            'id' => 2,
            'code' => 'size',
            'name' => 'size',
            'type' => 'select'
        ]);

        AttributeOption::create([
            'name' => 'hijau',
            'attribute_id' => $AttributeColor->id
        ]);
        AttributeOption::create([
            'name' => 'biru',
            'attribute_id' => $AttributeColor->id
        ]);
        AttributeOption::create([
            'name' => '40',
            'attribute_id' => $AttributeSize->id
        ]);
        AttributeOption::create([
            'name' => '20',
            'attribute_id' => $AttributeSize->id
        ]);
    }
}
