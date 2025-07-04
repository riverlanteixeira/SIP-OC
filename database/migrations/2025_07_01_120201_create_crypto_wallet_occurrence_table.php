<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('crypto_wallet_occurrence', function (Blueprint $table) {
            $table->foreignId('crypto_wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('occurrence_id')->constrained()->onDelete('cascade');
            $table->primary(['crypto_wallet_id', 'occurrence_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('crypto_wallet_occurrence');
    }
};
