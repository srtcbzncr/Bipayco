<?php

namespace App\Listeners\Live;

use App\Events\Live\StartLiveEvent;
use App\Jobs\StartLiveJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class StartLiveListener
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
     * @param  StartLiveEvent  $event
     * @return void
     */
    public function handle(StartLiveEvent $event)
    {
        $data['name'] = $event->to_name;
        $data['email'] = $event->to_mail;
        dispatch(new StartLiveJob($data));
    }
}
