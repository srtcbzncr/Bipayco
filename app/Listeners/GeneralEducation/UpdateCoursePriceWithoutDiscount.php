<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\DeleteDiscount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCoursePriceWithoutDiscount
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
     * @param  DeleteDiscount  $event
     * @return void
     */
    public function handle(DeleteDiscount $event)
    {
        $discount = $event->discount;
        $course = $discount->course;
        $course->price_with_discount = ($course->price_with_discount * 100) / (100 - $discount->discount_rate);
        $course->save();
    }
}
