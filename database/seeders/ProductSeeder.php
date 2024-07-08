<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                // 'uuid' =>  Uuid::uuid4(),
                // 'title' => 'pet dog 101',
                // 'price' => 1300.00,
                // 'description' => 'Order for pet dog 101',
                // 'meta' => [
                //     "brand" => Uuid::uuid4(),
                //     "image" => Uuid::uuid4()
                // ],
                // 'created_at' => now(),
            ],
        ];
        Product::insert($data);
    }
}
