<?php

namespace Ladmin\Engine\Listeners;

use Ladmin\Engine\Events\LadminLoginEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LadminLoginListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LadminLoginEvent $event)
    {
        $data = [
            'ip' => request()->ip(),
            'User Agent' => request()->userAgent(),
        ];
        $event->user->activities()->create([
            'loggable_type' => get_class($event->user),
            'loggable_id' => $event->user->id,
            'new_data' => $data,
            'old_data' => [],
            'type' => 'login',
        ]);
    }
}
