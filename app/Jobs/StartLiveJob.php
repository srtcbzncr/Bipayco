<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class StartLiveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name,$email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($veri)
    {
        $this->name = $veri['name'];
        $this->email = $veri['email'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to_name = $this->name;
        $to_email = $this->email;
        $data = array('name'=>"Sanalist AŞ", "body" => "CANLI YAYIN BAŞLADI");
        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('CANLI YAYIN');
            $message->from('info@bipayco.com','Canlı Yayın Başladı Bildirisi');
        });
    }
}