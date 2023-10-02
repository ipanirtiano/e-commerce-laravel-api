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
            $table->unsignedBigInteger("id_user")->nullable(false);
            $table->string("uuid")->nullable(false);
            $table->string("date")->nullable(false);
            $table->string("products")->nullable(false);
            $table->integer("amount")->nullable(false);
            $table->string("name")->nullable(false);
            $table->string("phone")->nullable(false);
            $table->string("address")->nullable(false);
            $table->string("package")->nullable(false);
            $table->string("status")->nullable(false);
            $table->timestamps();

            $table->foreign("id_user")->on("users")->references("id");
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
