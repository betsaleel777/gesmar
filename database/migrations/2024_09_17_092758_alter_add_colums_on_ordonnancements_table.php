<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('ordonnancements', function (Blueprint $table) {
            $table->string('nature_paiement')->nullable();
            $table->unsignedSmallInteger('timbre')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('ordonnancements', function (Blueprint $table) {
            $table->dropColumn('nature_paiement');
            $table->dropColumn('timbre');
        });
    }
};
