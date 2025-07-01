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
        Schema::create('crime_type_occurrence', function (Blueprint $table) {
            $table->foreignId('crime_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('occurrence_id')->constrained()->onDelete('cascade');
            $table->primary(['crime_type_id', 'occurrence_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crime_type_occurrence');
    }
};
