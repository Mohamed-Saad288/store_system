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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('product_id')->nullable()->constrained('products')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->integer('count')->nullable()->default(1);
            $table->string('price')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
