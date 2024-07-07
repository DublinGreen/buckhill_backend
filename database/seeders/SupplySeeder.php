<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supply;
use Illuminate\Support\Str;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'personnel_id' => random_int(1,5),
                'name' => 'Soil fertilizer',
                'description' => "Fertilisers are additional substances supplied to the crops to increase their productivity.",
                'size' => "20kg",
                'quantity' => "28",
                'status' => \App\Enums\SupplyStatus::UNUSED,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'Wheel Barrows',
                'description' => "Wheel barrows used to move produce to the barn",
                'size' => "18kg",
                'quantity' => "22",
                'status' => \App\Enums\SupplyStatus::INUSE,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'Fish Feed',
                'description' => "Fish feed and palatte used to feed the cat fishes",
                'size' => "5kg",
                'quantity' => "10",
                'status' => \App\Enums\SupplyStatus::EMPTY,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'name' => 'Tractors',
                'description' => "Tractors to be used during planting season",
                'size' => "540kg",
                'quantity' => "3",
                'status' => \App\Enums\SupplyStatus::INUSE,
                'created_at' => now(),
            ],
        ];
        Supply::insert($data);
    }
}
