<?php

namespace App\Listeners\UsersOperations;

use App\Events\UsersOperations\CreateLastWatchedCourse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LastWacthedCourse
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
     * @param  CreateLastWatchedCourse  $event
     * @return void
     */
    public function handle(CreateLastWatchedCourse $event)
    {
        //
    }
}
