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
        Schema::table('reparations', function (Blueprint $table) {
            $table->longText('description');
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reparations', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropConstrainedForeignId('site_is');
        });
    }
};
