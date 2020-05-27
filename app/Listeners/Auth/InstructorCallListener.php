<?php

namespace App\Listeners\Auth;

use App\Events\Auth\InstructorCallEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InstructorCallListener
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
     * @param  InstructorCallEvent  $event
     * @return void
     */
    public function handle(InstructorCallEvent $event)
    {
        $to_name = $event->to_name;
        $to_email = $event->to_mail;
        $data = array('name'=>"Sanalist AŞ", "body" => "Merhaba, bu bir kursa eğitmen olarak davet mesajıdır.");
        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
            $message->from('info@bipayco.com','Register Mail');
        });
    }
}
