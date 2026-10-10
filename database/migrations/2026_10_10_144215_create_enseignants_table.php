<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();

            $table->string('matricule')->nullable()->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('sexe', 20)->nullable();
            $table->date('date_naissance')->nullable();

            $table->string('telephone', 30)->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('adresse')->nullable();

            $table->string('diplome')->nullable();
            $table->string('specialite')->nullable();
            $table->date('date_recrutement')->nullable();

            $table->string('statut')->default('actif');
            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
