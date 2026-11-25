<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paiement_id')
                ->unique()
                ->constrained('paiements')
                ->restrictOnDelete();

            $table->string('numero_recu')->unique();

            $table->dateTime('date_emission');

            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};