<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'personnel_id' => random_int(1,5),
                'name' => 'maize',
                'description' => 'maize harvest',
                'quantity' => '50',
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'tomatoes',
                'description' => 'tomatoes harvest',
                'quantity' => '10',
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'water melons',
                'description' => 'water melons harvest',
                'quantity' => '250',
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'apples',
                'description' => 'apples harvest',
                'quantity' => '2500',
                'created_at' => now(),
            ],
        ];
        Product::insert($data);
    }
}
