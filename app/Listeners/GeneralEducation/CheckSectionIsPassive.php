<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\NewLesson;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckSectionIsPassive
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
     * @param  NewLesson  $event
     * @return void
     */
    public function handle(NewLesson $event)
    {
        //
    }
}
