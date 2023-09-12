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
        Schema::create('labs_petrequest', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->string('pet');
            $table->string('gender');
            $table->string('breed');
            $table->string('age_year');
            $table->string('age_month');
            $table->string('tutor');
            $table->string('vet_requester')->nullable();
            $table->date('collect_date')->nullable();
            $table->time('collect_hour')->nullable();
            $table->string('request_number');
            $table->string('status');
            $table->datetime('collected_date')->nullable();
            $table->boolean('collected');
            $table->string('observation')->nullable();
            $table->string('source')->nullable();
            $table->integer('lab');
            $table->integer('specie');
            $table->integer('requester');
            $table->integer('customer');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs_petrequest');
    }
};
