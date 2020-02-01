<?php

namespace App\Events\UsersOperations;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalculateCourseLong
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $course_id,$long;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($course_id,$long)
    {
        $this->course_id = $course_id;
        $this->long = $long;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
