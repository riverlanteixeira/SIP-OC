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
    Schema::create('organization_person', function (Blueprint $table) {
        // Chave estrangeira para a tabela 'organizations'
        $table->foreignId('organization_id')->constrained()->onDelete('cascade');

        // Chave estrangeira para a tabela 'people'
        $table->foreignId('person_id')->constrained()->onDelete('cascade');

        // Define que a combinação das duas chaves é a chave primária
        // Isso impede que a mesma pessoa seja vinculada à mesma organização duas vezes
        $table->primary(['organization_id', 'person_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_person');
    }
};
