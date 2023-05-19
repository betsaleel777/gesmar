<?php

namespace App\Providers;

use App\Http\Resources\Caisse\EncaissementListeResource;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Http\Resources\Caisse\OuvertureListResource;
use App\Http\Resources\Contrat\ContratListResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Contrat\DemandeAnnexeResource;
use App\Http\Resources\Contrat\DemandeBailResource;
use App\Http\Resources\Contrat\EquipementResource;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Facture\FactureLoyerResource;
use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use App\Http\Resources\Personne\PersonneListResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use App\Http\Resources\SiteResource;
use App\Http\Resources\SocieteResource;
use App\Http\Resources\TypePersonneResource;
use App\Http\Resources\UserResource;
use App\Models\Architecture\Equipement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FactureInitialeResource::withoutWrapping();
        FactureLoyerResource::withoutWrapping();
        OrdonnancementResource::withoutWrapping();
        FermetureListResource::withoutWrapping();
        OuvertureListResource::withoutWrapping();
        EncaissementListeResource::withoutWrapping();
        PersonneResource::withoutWrapping();
        PersonneListResource::withoutWrapping();
        SocieteResource::withoutWrapping();
        SiteResource::withoutWrapping();
        TypePersonneResource::withoutWrapping();
        ContratResource::withoutWrapping();
        ContratListResource::withoutWrapping();
        EquipementResource::withoutWrapping();
        ServiceAnnexeResource::withoutWrapping();
        UserResource::withoutWrapping();
    }
}
