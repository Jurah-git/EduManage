<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
    public function up(): void
    {
        Schema::create('creneaux_emploi_temps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('emploi_temps_id')
                ->constrained('emplois_temps')
                ->cascadeOnDelete();

            $table->foreignId('matiere_id')
                ->constrained('matieres')
                ->restrictOnDelete();

            $table->foreignId('enseignant_id')
                ->constrained('enseignants')
                ->restrictOnDelete();

            $table->foreignId('salle_id')
                ->constrained('salles')
                ->restrictOnDelete();

            $table->enum('jour', [
                'Lundi',
                'Mardi',
                'Mercredi',
                'Jeudi',
                'Vendredi',
                'Samedi',
            ]);

            $table->time('heure_debut');
            $table->time('heure_fin');

            $table->timestamps();

            $table->index([
                'jour',
                'heure_debut',
                'heure_fin',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux_emploi_temps');
    }
};