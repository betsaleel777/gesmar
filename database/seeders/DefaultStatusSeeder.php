<?php

namespace Database\Seeders;

use App\Models\Architecture\Abonnement;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Personne;
use Illuminate\Database\Seeder;

class DefaultStatusSeeder extends Seeder
{
    public function run(): void
    {
        $contrats = Contrat::withoutGlobalScopes()->get();
        $contrats->each(fn($contrat) => $contrat->validate());
        $abonnements = Abonnement::withoutGlobalScopes()->get();
        $abonnements->each(fn($abonnement) => $abonnement->process());
        Personne::withExists(['contrats as contratFound' => fn($query) => $query->validated()])->withoutGlobalScopes()->chunk(50, function ($personnes) {
            $personnes->each(fn($personne) => $personne->contratFound ? $personne->client() : $personne->prospect());
        });
    }
}
