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
        Schema::table('organization_person', function (Blueprint $table) {
            // Adiciona a coluna para guardar a função da pessoa na organização
            $table->string('role')->nullable()->after('person_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_person', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
