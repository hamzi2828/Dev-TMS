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
        Schema::create('capl_airline_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_id');
            $table->unsignedBigInteger('sector_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->foreign('airline_id', 'fk_airline_groups_airline_id')
                  ->references('id')
                  ->on('airlines')
                  ->onDelete('cascade');
                  
            $table->foreign('sector_id', 'fk_airline_groups_sector_id')
                  ->references('id')
                  ->on('sections')
                  ->onDelete('cascade');
        });
        
        Schema::create('capl_segments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_group_id');
            $table->date('departure_date');
            $table->unsignedBigInteger('airline_id');
            $table->string('flight_number');
            $table->string('origin');
            $table->string('destination');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->string('baggage')->nullable();
            $table->string('meal')->nullable();
            $table->timestamps();
            
            $table->foreign('airline_group_id')
                  ->references('id')
                  ->on('capl_airline_groups')
                  ->onDelete('cascade');
                  
            $table->foreign('airline_id')
                  ->references('id')
                  ->on('airlines')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capl_segments');
        Schema::dropIfExists('capl_airline_groups');
    }
};
