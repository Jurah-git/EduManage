<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // Un parent possède une seule conversation
            $table->foreignId('parent_id')
                ->unique()
                ->constrained('parents')
                ->cascadeOnDelete();

            // Date du dernier message
            $table->timestamp('last_message_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};