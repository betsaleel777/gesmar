<?php

namespace App\Providers;

use App\Models\Exploitation\Personne;
use App\Models\Template\TermesContratEmplacement;
use App\Policies\ClientPolicy;
use App\Policies\ProspectPolicy;
use App\Policies\TermesContratPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Personne::class => ProspectPolicy::class,
        Personne::class => ClientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user) {
            return $user->hasRole('Super-admin') ? true : null;
        });
    }
}
