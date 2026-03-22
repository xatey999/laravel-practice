<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatus;
use App\Enums\OrderPaymentStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', array_map(fn($case) => $case->value, OrderStatus::cases()))->default(OrderStatus::PENDING->value);
            $table->enum('payment_status', array_map(fn($case) => $case->value, OrderPaymentStatus::cases()))->default(OrderPaymentStatus::PENDING->value);
            $table->text('shipping_address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};