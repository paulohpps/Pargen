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
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->string('telefone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('endereco')->nullable()->change();
            $table->string('cnpj')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->string('telefone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('endereco')->nullable(false)->change();
            $table->string('cnpj')->nullable(false)->change();
        });
    }
};
