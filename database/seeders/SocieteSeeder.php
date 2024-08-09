<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Societe;
use Illuminate\Support\Facades\Schema;

class SocieteSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Societe::truncate();
        Schema::enableForeignKeyConstraints();
        Societe::create([
            'nom' => 'Société de Gestion du Grand Marché de Treichville',
            'capital' => 1000000,
            'siege' => 'Treichville',
            'sigle' => 'SGMT',
            'smartphone' => '1111111111',
            'phone' => '9999999999',
            'email' => 'infos@gesmarci.com'
        ]);
    }
}
