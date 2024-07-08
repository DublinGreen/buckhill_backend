<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained();
            $table->integer('order_status_id')->unsigned()->nullable()->constrained();
            $table->string('payment_id')->unique()->constrained();
            $table->string('uuid')->unique();
            $table->string('products');
            $table->string('address');
            $table->float('delivery_fee');
            $table->float('amount');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};