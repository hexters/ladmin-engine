<?php

namespace Ladmin\Engine;

use Ladmin\Engine\Events\LadminLoginEvent;
use Ladmin\Engine\Events\LadminLogoutEvent;
use Ladmin\Engine\Events\LadminResetPasswordEvent;
use Ladmin\Engine\Listeners\LadminLoginListener;
use Ladmin\Engine\Listeners\LadminLogoutListener;
use Ladmin\Engine\Listeners\LadminResetPasswordListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        LadminLoginEvent::class => [
            LadminLoginListener::class,
        ],
        LadminLogoutEvent::class => [
            LadminLogoutListener::class,
        ],
        LadminResetPasswordEvent::class => [
            LadminResetPasswordListener::class,
        ],
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
}
