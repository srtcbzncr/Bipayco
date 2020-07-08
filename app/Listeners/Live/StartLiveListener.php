<?php

namespace App\Listeners\Live;

use App\Events\Live\StartLiveEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class StartLiveListener
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
     * @param  StartLiveEvent  $event
     * @return void
     */
    public function handle(StartLiveEvent $event)
    {
        $to_name = $event->to_name;
        $to_email = $event->to_mail;
        $data = array('name'=>"Sanalist AŞ", "body" => "CANLI YAYIN BAŞLADI");
        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('CANLI YAYIN');
            $message->from('info@bipayco.com','Canlı Yayın Başladı Bildirisi');
        });
    }
}
