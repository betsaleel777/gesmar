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
        Schema::table('techniciens', function (Blueprint $table) {
            $table->string('telephone');
            $table->unique(['telephone', 'site_id'], 'telephone_site_uniq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('techniciens', function (Blueprint $table) {
            $table->dropUnique('telephone_site_uniq');
            $table->dropColumn('telephone');
        });
    }
};
