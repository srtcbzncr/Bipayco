<?php

namespace App\Listeners\Auth;

use App\Events\Auth\AdminRegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AdminRegisterListener
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
     * @param  AdminRegisterEvent  $event
     * @return void
     */
    public function handle(AdminRegisterEvent $event)
    {
        $to_name = $event->to_name;
        $to_email = $event->to_mail;
        $data = array('name'=>"$to_name", "body" => "Bipayco sistemine admin olarak eklendiniz.");
        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Bipayco Admin');
            $message->from('contact.softdevs@gmail.com','Bipayco Admin Register');
        });
    }
}
