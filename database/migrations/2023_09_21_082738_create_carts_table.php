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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_product")->nullable(false);
            $table->unsignedBigInteger("id_user")->nullable(false);
            $table->integer("amount");
            $table->timestamps();

            // set forign key
            $table->foreign("id_product")->on("products")->references("id");
            $table->foreign("id_user")->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
