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
        Schema::create('labs_analyze', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->string('name');
            $table->string('slug');
            $table->float('price');
            $table->integer('deadline');
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('default');
            $table->integer('order')->nullable();
            $table->integer('lab');
            $table->integer('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs_analyze');
    }
};
