<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sex');
            $table->date('birth_date');
            
            $table->foreignId('subspecies_id')->constrained('subspecies')->onDelete('cascade');
            $table->foreignId('enclosure_id')->constrained('enclosures')->onDelete('restrict');
            $table->foreignId('diet_plan_id')->constrained('diet_plans')->onDelete('restrict');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};