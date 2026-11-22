<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {

            $table->id();

            // Élève concerné
            $table->foreignId('eleve_id')
                ->constrained('eleves')
                ->restrictOnDelete();

            // Classe attribuée pour l'année
            $table->foreignId('classe_id')
                ->constrained('classes')
                ->restrictOnDelete();

            // Année scolaire concernée
            $table->foreignId('annee_scolaire_id')
                ->constrained('annee_scolaires')
                ->restrictOnDelete();

            // Informations de l'inscription
            $table->date('date_inscription');

            $table->enum('type', [
                'nouvelle_inscription',
                'reinscription',
            ]);

            $table->enum('statut', [
                'en_attente',
                'validee',
                'annulee',
            ])->default('en_attente');

            // Frais d'inscription
            $table->decimal('frais_inscription', 10, 2)
                ->default(0);

            // Observations administratives
            $table->text('observations')->nullable();

            $table->timestamps();

            // Empêcher les doublons pour un même élève
            // dans une même année scolaire
            $table->unique(
                ['eleve_id', 'annee_scolaire_id'],
                'inscriptions_eleve_annee_unique'
            );

            // Index pour faciliter les recherches
            $table->index(
                ['annee_scolaire_id', 'classe_id'],
                'inscriptions_annee_classe_index'
            );

            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};