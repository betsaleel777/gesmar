<?php

namespace App\Providers;

use App\Http\Resources\Caisse\EncaissementListeResource;
use App\Http\Resources\Caisse\FermetureListResource;
use App\Http\Resources\Caisse\OuvertureListResource;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Facture\FactureLoyerResource;
use App\Http\Resources\Ordonnancement\OrdonnancementResource;
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
    }
}
