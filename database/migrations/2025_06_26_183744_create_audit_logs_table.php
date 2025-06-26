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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // Ex: 'created', 'updated', 'deleted'
            $table->morphs('auditable'); // Colunas 'auditable_id' e 'auditable_type'
            $table->json('old_values')->nullable(); // Guarda os dados antigos (para updates)
            $table->json('new_values')->nullable(); // Guarda os dados novos (para updates e creates)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
