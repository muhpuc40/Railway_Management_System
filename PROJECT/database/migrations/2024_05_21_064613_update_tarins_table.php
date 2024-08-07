<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('trains', function (Blueprint $table) {

            $table->dropForeign(['route_id']);
            
            $table->foreign('route_id')
                ->references('id')->on('routes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }


    public function down(): void
    {
        Schema::table('trains', function (Blueprint $table) {
 
            $table->dropForeign(['route_id']);
            
            $table->foreign('route_id')
                ->references('id')->on('routes');
        });
    }
};
