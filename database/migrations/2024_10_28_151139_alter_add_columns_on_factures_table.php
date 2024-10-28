<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->integer('caution_abonnement')->nullable();
            $table->foreignId('abonnement_id')->nullable()->constrained('abonnements')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn('caution_abonnement');
            $table->dropConstrainedForeignId('abonnement_id');
        });
    }
};
