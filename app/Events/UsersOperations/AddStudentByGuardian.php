<?php

namespace App\Events\UsersOperations;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddStudentByGuardian
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id,$is_choice,$content,$accept_url,$reject_url,$redirect_url,$is_seen;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user_id = $data['userId'];
        $this->is_choice = $data['isChoice'];
        $this->content = $data['content'];
        $this->accept_url = $data['acceptUrl'];
        $this->reject_url = $data['rejectUrl'];
        $this->redirect_url = $data['redirectUrl'];
        $this->is_seen = $data['isSeen'];
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
