<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\CourseActiveEvent;
use App\Models\GeneralEducation\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseActiveListener
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
     * @param  CourseActiveEvent  $event
     * @return void
     */
    public function handle(CourseActiveEvent $event)
    {
        if($event->education == 1){
            $course = Course::find($event->course_id);
            $sections = $course->sections;
            foreach ($sections as $section){
                if($section->active == true){
                    $course->active = true;
                    $course->save();
                    break;
                }
            }
        }
        else if($event->education == 2){
            $course = \App\Models\PrepareLessons\Course::find($event->course_id);
            $sections = $course->sections;
            foreach ($sections as $section) {
                if ($section->active == true) {
                    $course->active = true;
                    $course->save();
                    break;
                }
            }
        }
        else if($event->education == 3){
            $course = \App\Models\PrepareExams\Course::find($event->course_id);
            $sections = $course->sections;
            foreach ($sections as $section) {
                if ($section->active == true) {
                    $course->active = true;
                    $course->save();
                    break;
                }
            }
        }
    }
}
