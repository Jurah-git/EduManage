<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_frais', function (Blueprint $table) {
            $table->id();

            // Nom du type de frais
            $table->string('nom');

            // Description facultative
            $table->text('description')->nullable();

            // Fréquence du paiement
            $table->enum('frequence', [
                'unique',
                'mensuelle',
                'trimestrielle',
                'annuelle',
            ])->default('unique');

            // Activation ou désactivation
            $table->boolean('actif')->default(true);

            $table->timestamps();

            $table->index('actif');
            $table->index('frequence');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types_frais');
    }
};