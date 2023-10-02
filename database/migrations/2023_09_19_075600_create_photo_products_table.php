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
        Schema::create('photo_products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(false);
            $table->unsignedBigInteger('id_product')->nullable(false);
            $table->timestamps();

            // set forign key
            $table->foreign("id_product")->on("products")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_products');
    }
};
