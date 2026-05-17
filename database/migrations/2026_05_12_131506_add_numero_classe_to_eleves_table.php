<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eleves', function (Blueprint $table) {

            $table->integer('numero_classe')
                  ->nullable()
                  ->after('classe_id');

        });
    }

    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {

            $table->dropColumn('numero_classe');

        });
    }
};