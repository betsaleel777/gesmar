<?php

namespace Database\Seeders;

use App\Models\Architecture\Abonnement;
use App\Models\Exploitation\Contrat;
use Illuminate\Database\Seeder;

class DefaultStatusSeeder extends Seeder
{
    public function run(): void
    {
        $contrats = Contrat::withoutGlobalScopes()->get();
        $contrats->each(fn($contrat) => $contrat->validate());
        $abonnements = Abonnement::withoutGlobalScopes()->get();
        $abonnements->each(fn($abonnement) => $abonnement->process());
    }
}
