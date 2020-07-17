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

    public $name,$email,$course;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($veri)
    {
        $this->name = $veri['name'];
        $this->email = $veri['email'];
        $this->course = $veri['course'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $to_name = $this->name;
            $to_email = $this->email;
            $to_course = $this->course;
            $data = array('name'=>$to_name, "body" => "Canlı Yayın Başladı",'course' => $to_course);
            Mail::send('live_email', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('CANLI YAYIN');
                $message->from('info@bipayco.com','Bipayco');
            });
        }catch(\Exception $e){

        }

    }
}
