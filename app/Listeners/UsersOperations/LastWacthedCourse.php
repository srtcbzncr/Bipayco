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
        $lastWatchedCourse = LastWacthedCourse::where('student_id',$event->student_id)
        ->where('course_type',$event->course_type)->where('course_id',$event->course_id)->first();
        if($lastWatchedCourse==null){
            $lastWatchedCourse = new LastWacthedCourse();
            $lastWatchedCourse->student_id = $event->student_id;
            $lastWatchedCourse->course_type = $event->course_type;
            $lastWatchedCourse->course_id = $event->course_id;

            $lastWatchedCourse->save();
        }
        else{
            $lastWatchedCourse->delete();
            $lastWatchedCourse = null;

            $lastWatchedCourse = new LastWacthedCourse();
            $lastWatchedCourse->student_id = $event->student_id;
            $lastWatchedCourse->course_type = $event->course_type;
            $lastWatchedCourse->course_id = $event->course_id;

            $lastWatchedCourse->save();
        }
    }
}
