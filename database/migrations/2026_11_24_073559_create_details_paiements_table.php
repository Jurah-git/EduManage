<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('details_paiements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paiement_id')
                ->constrained('paiements')
                ->restrictOnDelete();

            $table->foreignId('eleve_frais_id')
                ->constrained('eleves_frais')
                ->restrictOnDelete();

            $table->decimal('montant_paye', 12, 2);

            $table->timestamps();

            // Un même frais ne peut apparaître qu'une fois
            // dans un même paiement.
            $table->unique(
                ['paiement_id', 'eleve_frais_id'],
                'details_paiements_unique'
            );

            $table->index('eleve_frais_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('details_paiements');
    }
};