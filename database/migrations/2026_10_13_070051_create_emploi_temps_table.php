
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emplois_temps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('classe_id')
                ->constrained('classes')
                ->restrictOnDelete();

            $table->foreignId('annee_scolaire_id')
                ->constrained('annee_scolaires')
                ->restrictOnDelete();

            $table->string('titre')->nullable();

            $table->enum('statut', [
                'brouillon',
                'publie',
            ])->default('brouillon');

            $table->timestamps();

            $table->unique(
                ['classe_id', 'annee_scolaire_id'],
                'emploi_classe_annee_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emplois_temps');
    }
};