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
        Schema::create('labs_customer', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active');
            $table->datetime('create_at');
            $table->datetime('updated_at');
            $table->string('name');
            $table->string('sexo');
            $table->string('cnpj_cpf');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('number');
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('state');
            $table->string('complement')->nullable();
            $table->string('obs')->nullable();
            $table->integer('lab');
            $table->string('state_registration_rg')->nullable();
            $table->string('customer_type');
            $table->datetime('birthday')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('oficial_depart_number')->nullable();
            $table->string('oficial_service_vet')->nullable();
            $table->string('trading_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs_customer');
    }
};
