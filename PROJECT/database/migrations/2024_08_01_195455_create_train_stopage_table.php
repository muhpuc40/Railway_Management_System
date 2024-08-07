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
        Schema::create('train_stopage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('source_station');
            $table->string('sequence');
            $table->string('time');
            $table->timestamps();

            $table->foreign('train_id')->references('id')->on('train_list')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('train_day')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_stopage');
    }
};
