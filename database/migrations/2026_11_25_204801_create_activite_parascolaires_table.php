
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activite_parascolaires', function (Blueprint $table) {
            $table->id();

            // Informations générales
            $table->string('nom', 150);
            $table->string('categorie', 100);
            $table->text('description')->nullable();

            // Tarif indicatif
            $table->decimal('tarif_indicatif', 12, 2)->nullable();
            $table->string('periodicite')->nullable();

            // Organisation
            $table->json('jours')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();

            // Statut
            $table->boolean('actif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activite_parascolaires');
    }
};
