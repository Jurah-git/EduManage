
<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
    public function up(): void
    {
        Schema::create('salles', function (Blueprint $table) {
            $table->id();

            // Code automatique : SAL-0001, SAL-0002...
            $table->string('code')->nullable()->unique();

            $table->string('nom');
            $table->string('batiment')->nullable();
            $table->string('etage')->nullable();

            $table->unsignedInteger('capacite')->default(40);

            $table->enum('type', [
                'Ordinaire',
                'Laboratoire',
                'Informatique',
                'Autre',
            ])->default('Ordinaire');

            $table->enum('statut', [
                'Disponible',
                'Maintenance',
                'Indisponible',
            ])->default('Disponible');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};