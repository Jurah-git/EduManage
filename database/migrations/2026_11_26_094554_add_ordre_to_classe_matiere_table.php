<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('classe_matiere', 'ordre')) {
            Schema::table('classe_matiere', function (Blueprint $table) {
                $table->unsignedInteger('ordre')
                    ->default(0)
                    ->after('matiere_id');
            });
        }

        // Initialiser l'ordre des matières déjà associées
        $associations = DB::table('classe_matiere')
            ->orderBy('classe_id')
            ->orderBy('matiere_id')
            ->get()
            ->groupBy('classe_id');

        foreach ($associations as $matieres) {
            foreach ($matieres as $index => $matiere) {
                DB::table('classe_matiere')
                    ->where('id', $matiere->id)
                    ->update([
                        'ordre' => $index + 1,
                    ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('classe_matiere', 'ordre')) {
            Schema::table('classe_matiere', function (Blueprint $table) {
                $table->dropColumn('ordre');
            });
        }
    }
};