<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj  = User::find(1);
        // $obj2 = User::find(2);
        // $obj3 = User::find(3);

        $data = [
            [
                'uuid' => Uuid::uuid4(),
                'user_id' => $obj->id,
                'payment_id' => $obj->uuid,
                'products' => 'Dog 101',
                'products' => "
                [
                    {
                        'product': 'string_uuid',
                        'quantity': $obj->id
                    }
                ]
                ",
                'address' => "{
                    'billing': 'string',
                    'shipping': 'string'
                }",
                'amount' => 1300.00,
                'delivery_fee' => 100.00,
                'shipped_at' => now(),
                'created_at' => now(),
            ],
        ];
        Order::insert($data);
    }
}
