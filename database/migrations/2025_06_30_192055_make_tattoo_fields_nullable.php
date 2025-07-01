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
        Schema::table('tattoos', function (Blueprint $table) {
            // Altera as colunas para permitir valores nulos
            $table->string('body_part')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tattoos', function (Blueprint $table) {
            // Reverte as colunas para não permitirem nulos (se necessário)
            $table->string('body_part')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
};
