<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\NewPurchase;
use App\Models\GeneralEducation\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateCoursePurchaseCount
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
     * @param  NewPurchase  $event
     * @return void
     */
    public function handle(NewPurchase $event)
    {
        $course = $event->purchase->course;
        $count = $course->purchase_count;
        $course->purchase_count = $count + 1;
        $course->save();
    }
}
