<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('bank_account_occurrence', function (Blueprint $table) {
            $table->foreignId('bank_account_id')->constrained()->onDelete('cascade');
            $table->foreignId('occurrence_id')->constrained()->onDelete('cascade');
            $table->primary(['bank_account_id', 'occurrence_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('bank_account_occurrence');
    }
};
