<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(

            'bulletins',

            function (
                Blueprint $table
            ) {

                $table->id();

                $table->foreignId(
                    'eleve_id'
                )

                    ->constrained()

                    ->onDelete(
                        'cascade'
                    );

                $table->longText(
                    'image_base64'
                )

                    ->nullable();

                $table->timestamps();
            }

        );
    }

    public function down(): void
    {

        Schema::dropIfExists(
            'bulletins'
        );
    }
};
