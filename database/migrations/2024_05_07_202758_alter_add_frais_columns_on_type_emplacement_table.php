<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('type_emplacements', function (Blueprint $table) {
            $table->unsignedInteger('frais_dossier')->default(0);
            $table->unsignedInteger('frais_amenagement')->default(0);
        });
    }

    public function down()
    {
        Schema::table('type_emplacements', function (Blueprint $table) {
            $table->dropColumn('frais_dossier');
            $table->dropColumn('frais_amenagement');
        });
    }
};
