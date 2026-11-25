
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ecole_settings', function (Blueprint $table) {
            $table->json('modes_paiement_config')
                ->nullable()
                ->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('ecole_settings', function (Blueprint $table) {
            $table->dropColumn('modes_paiement_config');
        });
    }
};
