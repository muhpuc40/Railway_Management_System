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
            $table->id(); // Primary key, auto-increment
            $table->string('name')->nullable(); // Name field, allows NULL
            $table->string('email', 30)->nullable(); // Email field, with a maximum of 30 characters
            $table->string('phone', 20)->nullable(); // Phone field, with a maximum of 20 characters
            $table->double('amount')->nullable(); // Amount field, double precision
            $table->text('address')->nullable(); // Address field
            $table->string('status', 10)->nullable(); // Status field, with a maximum of 10 characters
            $table->string('transaction_id', 255)->nullable(); // Transaction ID field, maximum of 255 characters
            $table->string('currency', 20)->nullable(); // Currency field, with a maximum of 20 characters
            $table->timestamps(); // Created at, updated at fields
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
