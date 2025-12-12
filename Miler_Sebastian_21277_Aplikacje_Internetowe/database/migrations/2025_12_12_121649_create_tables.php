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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('cares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('enclosures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('for');
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('subspecies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nickname')->unique();
            $table->string('name');
            $table->string('last_name');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
