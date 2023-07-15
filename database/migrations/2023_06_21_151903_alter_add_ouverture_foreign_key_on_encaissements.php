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
        Schema::table('encaissements', function (Blueprint $table) {
            $table->foreignId('ouverture_id')->nullable()->constrained('ouvertures')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encaissements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ouverture_id');
        });
    }
};
