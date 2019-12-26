<?php

namespace App\Listeners\GeneralEducation;

use App\Events\GeneralEducation\CreateDiscount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCoursePriceWithDiscount
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
     * @param  CreateDiscount  $event
     * @return void
     */
    public function handle(CreateDiscount $event)
    {
        $discount = $event->discount;
        $course = $discount->course;
        $course->price_with_discount = ($course->price_with_discount * (100 - $discount->discount_rate)) / 100;
        $course->save();
    }
}
