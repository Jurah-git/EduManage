<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            $table->string('numero_paiement')->unique();

            $table->foreignId('eleve_id')
                ->constrained('eleves')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('date_paiement');

            $table->decimal('montant_total', 12, 2);

            // Paiement uniquement en espèces
            $table->enum('mode_paiement', [
                'especes',
            ])->default('especes');

            $table->enum('statut', [
                'valide',
                'annule',
            ])->default('valide');

            $table->text('observations')->nullable();

            $table->timestamps();

            $table->index(['eleve_id', 'statut']);
            $table->index('date_paiement');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};