<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\SectionActiveEvent;
use App\Models\GeneralEducation\Section;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SectionActiveListener
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
     * @param  SectionActiveEvent  $event
     * @return void
     */
    public function handle(SectionActiveEvent $event)
    {
        if($event->education == 1){
            $section = Section::find($event->section_id);
            $lessons = $section->lessons;
            foreach ($lessons as $lesson){
                if($lesson->active == true){
                    $section->active = true;
                    $section->save();
                    break;
                }
            }
        }
        else if($event->education == 2){
            $section = \App\Models\PrepareLessons\Section::find($event->section_id);
            $lessons = $section->lessons;
            foreach ($lessons as $lesson){
                if($lesson->active == true){
                    $section->active = true;
                    $section->save();
                    break;
                }
            }
        }
    }
}
