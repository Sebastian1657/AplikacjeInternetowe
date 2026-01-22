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
        Schema::create('subspecies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->constrained('species')->onDelete('cascade');
            $table->string('common_name');
            $table->string('scientific_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subspecies');
    }
};
