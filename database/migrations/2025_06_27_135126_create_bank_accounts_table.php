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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->morphs('ownerable'); // Cria ownerable_id e ownerable_type
            $table->string('bank_name');
            $table->string('agency_number');
            $table->string('account_number');
            $table->string('account_type')->nullable(); // Ex: Conta Corrente, Poupança
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
