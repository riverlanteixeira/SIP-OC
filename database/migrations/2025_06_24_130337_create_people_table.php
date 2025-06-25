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
    Schema::create('people', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->string('cpf')->unique()->nullable(); // CPF único, mas pode ser nulo
        $table->date('birth_date')->nullable(); // Data de nascimento, pode ser nula
        $table->text('notes')->nullable(); // Campo para anotações gerais
        $table->string('photo_path')->nullable(); // Caminho para a foto da pessoa
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
