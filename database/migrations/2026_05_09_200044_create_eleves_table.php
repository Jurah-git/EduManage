<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {

            $table->id();

            $table->string('nom');

            $table->string('prenom');

            $table->string('matricule')->nullable();

            $table->string('sexe')->nullable();

            $table->date('date_naissance')->nullable();

            $table->foreignId('classe_id')
                ->nullable()
                ->constrained('classes')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};