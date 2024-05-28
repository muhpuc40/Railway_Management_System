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
        Schema::create('reservation_list', function (Blueprint $table) {
            $table->id();
            $table->string('seat_num',100);
            $table->integer('schedule_id');
            $table->dateTime('schedule');
            $table->string('name',100);
            $table->string('seat_type',100);
            $table->string('fare_amount',100);
            $table->dateTime('date_created')->default(DB::raw('CURRENT_TIMESTAMP')); 
            $table->dateTime('date_updated')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP')); 
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_list');
    }
};
