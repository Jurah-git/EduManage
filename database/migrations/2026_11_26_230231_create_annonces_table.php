
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();

            $table->string('titre');
            $table->string('categorie')->default('information');
            $table->longText('contenu');

            // Brouillon ou publié
            $table->enum('statut', ['brouillon', 'publie'])
                ->default('brouillon');

            // Public visé
            $table->enum('public_cible', ['tous', 'parents'])
                ->default('parents');

            $table->dateTime('date_publication')->nullable();

            // Auteur de l'annonce
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['statut', 'date_publication']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
