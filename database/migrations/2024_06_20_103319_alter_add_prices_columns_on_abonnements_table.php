<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abonnements', function (Blueprint $table) {
            $table->unsignedInteger('prix_fixe')->default(0);
            $table->unsignedInteger('prix_unitaire')->default(0);
            $table->unsignedInteger('frais_facture')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abonnements', function (Blueprint $table) {
            $table->dropColumn('prix_fixe');
            $table->dropColumn('prix_unitaire');
            $table->dropColumn('frais_facture');
        });
    }
};
