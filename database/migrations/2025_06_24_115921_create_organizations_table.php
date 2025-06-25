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
    Schema::create('organizations', function (Blueprint $table) {
        $table->id(); // Cria uma coluna de ID auto-incremental (1, 2, 3...)
        $table->string('name'); // Cria uma coluna de texto para o nome
        $table->text('description')->nullable(); // Cria um campo de texto longo para a descrição, que pode ser nulo
        $table->string('area_of_operation')->nullable(); // Cria uma coluna de texto para a área de atuação, que pode ser nula
        $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at' automaticamente
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
