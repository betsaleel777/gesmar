<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('encaissements', function (Blueprint $table) {
            $table->string('code', 10)->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('encaissements', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
