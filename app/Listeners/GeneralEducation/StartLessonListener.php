<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\StartLessonEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StartLessonListener
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
     * @param  StartLessonEvent  $event
     * @return void
     */
    public function handle(StartLessonEvent $event)
    {
        $student = $event->student;
        $course = $event->course;
        $student->geCompleted()->detach($course);
        $student->geCompleted()->attach($course, ['is_completed' => false]);
    }
}
