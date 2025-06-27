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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->unique()->comment('Placa');
            $table->string('brand')->nullable()->comment('Marca');
            $table->string('model')->nullable()->comment('Modelo');
            $table->year('year')->nullable()->comment('Ano');
            $table->string('color')->nullable()->comment('Cor');
            $table->string('fuel_type')->nullable()->comment('Combustível');
            $table->string('renavam')->nullable()->unique();
            $table->string('chassis')->nullable()->unique();
            $table->text('notes')->nullable()->comment('Observações');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
