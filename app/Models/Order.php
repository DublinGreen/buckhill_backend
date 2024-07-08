<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'user_id',
      'order_status_id',
      'payment_id',
      'uuid',
      'products',
      'address',
      'delivery_fee',
      'amount',
      'shipped_at',
      'created_at',
      'updated_at'
    ];
}