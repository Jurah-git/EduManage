
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonce_parent_lues', function (Blueprint $table) {
            $table->id();

            $table->foreignId('annonce_id')
                ->constrained('annonces')
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->constrained('parents')
                ->cascadeOnDelete();

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->unique(['annonce_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonce_parent_lues');
    }
};
