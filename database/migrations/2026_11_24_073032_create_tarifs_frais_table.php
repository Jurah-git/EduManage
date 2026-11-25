<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifs_frais', function (Blueprint $table) {
            $table->id();

            $table->foreignId('type_frais_id')
                ->constrained('types_frais')
                ->restrictOnDelete();

            $table->foreignId('annee_scolaire_id')
                ->constrained('annee_scolaires')
                ->restrictOnDelete();

            $table->foreignId('classe_id')
                ->constrained('classes')
                ->restrictOnDelete();

            // Montant en Ariary
            $table->decimal('montant', 12, 2);

            // Période de validité facultative
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            $table->boolean('actif')->default(true);

            $table->timestamps();

            // Éviter deux tarifs identiques pour le même type,
            // la même année scolaire et la même classe.
            $table->unique(
                ['type_frais_id', 'annee_scolaire_id', 'classe_id'],
                'tarifs_frais_unique'
            );

            $table->index('actif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifs_frais');
    }
};