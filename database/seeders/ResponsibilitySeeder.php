<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Responsibility;
use Illuminate\Support\Str;

class ResponsibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'personnel_id' => random_int(1,5),
                'task' => 'Feed the goats',
                'description' => "Feed the goats twice daily",
                'status' => \App\Enums\ResponsibilityStatus::PENDING,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'task' => 'Plant the maize seeds',
                'description' => "Plant some maize seeds, 1 hectare of land per week",
                'status' => \App\Enums\ResponsibilityStatus::DONE,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'task' => 'Fix the tractor',
                'description' => "Contact the mechanic and fix the tractor need before next summer.",
                'status' => \App\Enums\ResponsibilityStatus::PENDING,
                'created_at' => now(),
            ],
            [
                'personnel_id' => random_int(1,5),
                'task' => 'Transport farm products to city stores',
                'description' => "Call distributors and move products to city stores",
                'status' => \App\Enums\ResponsibilityStatus::PENDING,
                'created_at' => now(),
            ],
        ];
        Responsibility::insert($data);
    }
}
