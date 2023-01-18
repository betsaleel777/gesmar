<?php

namespace App\Providers;

use App\Listeners\AbonnementSubscriber;
use App\Listeners\CollecteSubscriber;
use App\Listeners\ContratSubscriber;
use App\Listeners\EncaissementSubscriber;
use App\Listeners\EquipementSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Undocumented variable
     *
     * @var array<int, class-string>
     */
    protected $subscribe = [
        ContratSubscriber::class,
        AbonnementSubscriber::class,
        EquipementSubscriber::class,
        EncaissementSubscriber::class,
        CollecteSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
