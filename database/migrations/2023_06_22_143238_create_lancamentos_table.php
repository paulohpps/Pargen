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
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_pagamento');
            $table->integer('pagamento_id')->nullable();
            $table->integer('fornecedor_id')->nullable();
            $table->integer('funcionario_id')->nullable();
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('vencimento');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos');
    }
};
