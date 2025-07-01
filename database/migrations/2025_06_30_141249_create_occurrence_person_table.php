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
        Schema::create('occurrence_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('occurrence_id')->constrained()->onDelete('cascade');
            $table->foreignId('person_id')->constrained()->onDelete('cascade');
            $table->string('participation_type'); // Ex: 'Suspeito', 'Vítima', 'Testemunha'
            $table->text('individual_report')->nullable();
            $table->timestamps();

            // Garante que a mesma pessoa não pode ser adicionada à mesma ocorrência duas vezes
            $table->unique(['occurrence_id', 'person_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occurrence_person');
    }
};
