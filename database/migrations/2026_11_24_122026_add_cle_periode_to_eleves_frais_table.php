<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eleves_frais', function (Blueprint $table) {
            $table->string('cle_periode', 30)->after('libelle');

            $table->unique(
                ['eleve_id', 'tarif_frais_id', 'cle_periode'],
                'eleves_frais_periode_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('eleves_frais', function (Blueprint $table) {
            $table->dropUnique('eleves_frais_periode_unique');
            $table->dropColumn('cle_periode');
        });
    }
};