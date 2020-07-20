<?php

namespace App\Listeners\UsersOperations;

use App\Events\UsersOperations\CalculateCourseLong;
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
        if($event->course_type == 1){
            $course = Course::find($event->course_id);
            $long = $course->long + ($event->long/3600);
            $course->long = $long;
            $course->save();
        }
        else if($event->course_type == 2){
            $course = \App\Models\PrepareLessons\Course::find($event->course_id);
            $long = $course->long + ($event->long/3600);
            $course->long = $long;
            $course->save();
        }
        else if($event->course_type == 3){
            $course = \App\Models\PrepareExams\Course::find($event->course_id);
            $long = $course->long + ($event->long/3600);
            $course->long = $long;
            $course->save();
        }
    }
}
