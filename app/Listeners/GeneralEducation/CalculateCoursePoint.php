<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\NewComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GeneralEducation\Course;

class CalculateCoursePoint
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
     * @param  NewComment  $event
     * @return void
     */
    public function handle(NewComment $event)
    {
        $comment = $event->comment;
        $course = Course::find($comment->course_id);
        $comments = $course->comments;
        $totalPoint = 0;
        $commentCount = 0;
        foreach ($comments as $comment){
            $totalPoint = $totalPoint + $comment->point;
            $commentCount = $commentCount + 1;
        }
        $newPoint = $totalPoint / $commentCount;
        $course->point = $newPoint;
        $course->save();
    }
}
