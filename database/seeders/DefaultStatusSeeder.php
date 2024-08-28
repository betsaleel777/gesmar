<?php

namespace Database\Seeders;

use App\Models\Exploitation\Personne;
use Illuminate\Database\Seeder;

class DefaultStatusSeeder extends Seeder
{
    public function run(): void
    {
        Personne::withExists(['contrats as contratFound' => fn($query) => $query->validated()])->withoutGlobalScopes()->chunk(50, function ($personnes) {
            $personnes->each(fn($personne) => $personne->contratFound ? $personne->client() : $personne->prospect());
        });
    }
}
