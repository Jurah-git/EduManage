<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table(
            'classe_matiere',

            function(Blueprint $table){

                $table->integer(
                    'coef'
                )

                ->default(1);

            }
        );
    }

    public function down()
    {
        Schema::table(
            'classe_matiere',

            function(Blueprint $table){

                $table->dropColumn(
                    'coef'
                );

            }
        );
    }

};