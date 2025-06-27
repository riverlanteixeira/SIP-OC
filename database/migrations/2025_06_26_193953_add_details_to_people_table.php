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
        Schema::table('people', function (Blueprint $table) {
            // Adiciona as novas colunas após a coluna 'birth_date'
            $table->after('birth_date', function ($table) {
                $table->string('rg')->nullable();
                $table->string('nickname')->nullable()->comment('Alcunha');
                $table->string('father_name')->nullable();
                $table->string('mother_name')->nullable();
                $table->string('nationality')->nullable();
                $table->string('birth_place')->nullable()->comment('Naturalidade');
                $table->string('gender')->nullable();
                $table->string('skin_color')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn([
                'rg', 'nickname', 'father_name', 'mother_name', 
                'nationality', 'birth_place', 'gender', 'skin_color'
            ]);
        });
    }
};
