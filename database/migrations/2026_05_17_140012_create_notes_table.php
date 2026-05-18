<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('eleve_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('periode_id')->nullable()->constrained()->onDelete('set null');

            $table->enum('type', ['journalier', 'composition']);

            $table->float('valeur')->default(0);
            $table->float('coef')->default(1);
            $table->float('base')->default(20);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};