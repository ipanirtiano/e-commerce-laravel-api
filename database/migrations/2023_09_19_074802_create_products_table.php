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
            $table->string("uuid")->nullable(false);
            $table->string("product_name", 100)->nullable(false);
            $table->string("categories", 50)->nullable(false);
            $table->string("color", 50)->nullable();
            $table->string("size", 50)->nullable();
            $table->string("storage", 50)->nullable(false);
            $table->text("description")->nullable(false);
            $table->integer("price")->nullable(false);
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
