<?php

namespace App\Listeners\Auth;

use App\Events\Auth\RegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RegisterListener
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
     * @param  RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        $to_name = $event->to_name;
        $to_email = $event->to_mail;
        $data = array('name'=>"Sanalist AŞ", "body" => "Merhaba, bu bir hoşgeldin mesajıdır.");
        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
            $message->from('contact.softdevs@gmail.com','Register Mail');
        });
    }
}
