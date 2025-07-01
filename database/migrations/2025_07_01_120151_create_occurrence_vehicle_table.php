<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('occurrence_vehicle', function (Blueprint $table) {
            $table->foreignId('occurrence_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->primary(['occurrence_id', 'vehicle_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('occurrence_vehicle');
    }
};
