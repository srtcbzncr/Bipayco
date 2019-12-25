<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\FinishLessonEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FinishLessonListener
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
     * @param  FinishLessonEvent  $event
     * @return void
     */
    public function handle(FinishLessonEvent $event)
    {
        $student = $event->student;
        $course = $event->course;
        $student->geCompleted()->detach($course);
        $student->geCompleted()->attach($course, ['is_completed' => true]);
    }
}
