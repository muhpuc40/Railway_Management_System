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
        Schema::create('fares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('destination_id');
            $table->string('class');
            $table->decimal('fare', 8, 2);
            $table->timestamps();

            $table->foreign('train_id')->references('id')->on('train_list')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('train_stopage')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('train_stopage')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fares');
    }
};
