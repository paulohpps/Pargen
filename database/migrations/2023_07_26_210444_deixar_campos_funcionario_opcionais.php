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
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->string('cpf')->nullable()->change();
            $table->string('cargo')->nullable()->change();
            $table->decimal('valor_vencimento', 10, 2)->nullable()->change();
            $table->decimal('encargos', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->string('cpf')->nullable(false)->change();
            $table->string('cargo')->nullable(false)->change();
            $table->decimal('valor_vencimento', 10, 2)->nullable(false)->change();
            $table->decimal('encargos', 10, 2)->nullable(false)->change();
        });
    }
};
