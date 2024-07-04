<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'uuid',
      'user_id',
      'payment_id',
      'products',
      'address',
      'amount',
      'delivery_fee',
      'shipped_at',
      'created_at',
      'updated_at'
    ];
}