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
        Schema::create('train_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id');
            $table->string('coach');
            $table->string('class');
            $table->string('capacity');
            $table->timestamps();
            $table->foreign('train_id')->references('id')->on('train_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_details');
    }
};
