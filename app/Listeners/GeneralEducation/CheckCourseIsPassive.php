<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\SectionIsActive;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckCourseIsPassive
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
     * @param  SectionIsActive  $event
     * @return void
     */
    public function handle(SectionIsActive $event)
    {
        //
    }
}
