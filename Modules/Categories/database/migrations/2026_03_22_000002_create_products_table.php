<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProductStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', array_map(fn($case) => $case->value, ProductStatus::cases()))->default(ProductStatus::ACTIVE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};