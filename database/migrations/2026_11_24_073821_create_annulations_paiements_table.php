<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annulations_paiements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paiement_id')
                ->unique()
                ->constrained('paiements')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('motif');

            $table->dateTime('date_annulation');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annulations_paiements');
    }
};