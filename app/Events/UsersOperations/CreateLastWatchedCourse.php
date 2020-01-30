<?php

namespace App\Events\UsersOperations;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateLastWatchedCourse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student_id, $course_type, $course_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($student_id,$course_type,$course_id)
    {
        $this->student_id = $student_id;
        $this->course_type = $course_type;
        $this->course_id = $course_id;
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
