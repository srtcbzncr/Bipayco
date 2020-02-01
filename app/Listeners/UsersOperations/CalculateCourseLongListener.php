<?php

namespace App\Listeners\UsersOperations;

use App\Events\CalculateCourseLong;
use App\Models\GeneralEducation\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateCourseLongListener
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
     * @param  CalculateCourseLong  $event
     * @return void
     */
    public function handle(CalculateCourseLong $event)
    {
        $course = null;
        if($event->getType == "App\Models\GeneralEducation\Course"){
            $course = Course::find($event->course_id);
            $long = $course->long + ($event->long/3600);
            $course->long = $long;
            $course->save();
        }
        else if($event->getType == "App\Models\PrepareLessons\Course"){
            $course = \App\Models\PrepareLessons\Course::find($event->course_id);
            $long = $course->long + ($event->long/3600);
            $course->long = $long;
            $course->save();
        }
    }
}
