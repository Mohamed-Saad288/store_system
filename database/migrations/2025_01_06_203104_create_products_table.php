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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("section")->nullable();
            $table->string("price_before_discount")->nullable();
            $table->string("price_after_discount")->nullable();
            $table->string("code")->nullable();
            $table->tinyInteger("status")->nullable()->default(1)->comment("1 active |2 inactive");
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
