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
        Schema::create('occurrences', function (Blueprint $table) {
            $table->id();
            $table->string('bo_number')->unique()->comment('Número do Boletim de Ocorrência');
            $table->dateTime('fact_date')->comment('Data e Hora do Fato');
            // Chave estrangeira para o local (pode ser nulo se o local não for especificado)
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->text('report')->comment('Relato geral da ocorrência');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occurrences');
    }
};
