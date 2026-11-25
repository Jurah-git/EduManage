<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleves_frais', function (Blueprint $table) {
            $table->id();

            $table->foreignId('eleve_id')
                ->constrained('eleves')
                ->restrictOnDelete();

            $table->foreignId('tarif_frais_id')
                ->constrained('tarifs_frais')
                ->restrictOnDelete();

            // Libellé du frais
            $table->string('libelle');

            // Montant initial à payer
            $table->decimal('montant_du', 12, 2);

            // Période concernée : par exemple septembre 2026
            $table->unsignedTinyInteger('mois')->nullable();
            $table->unsignedSmallInteger('annee')->nullable();

            // Date limite de paiement
            $table->date('date_echeance')->nullable();

            // Statut financier
            $table->enum('statut', [
                'impaye',
                'partiel',
                'paye',
            ])->default('impaye');

            $table->timestamps();

            $table->index(['eleve_id', 'statut']);
            $table->index(['mois', 'annee']);
            $table->index('date_echeance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves_frais');
    }
};