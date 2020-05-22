<?php

namespace App\Listeners\UsersOperations;

use App\Events\UsersOperations\AddStudentByGuardian;
use App\Models\UsersOperations\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AddStudentByGuardianListener
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
     * @param  AddStudentByGuardian  $event
     * @return void
     */
    public function handle(AddStudentByGuardian $event)
    {
        try {
            DB::beginTransaction();
            $notification = new Notification();
            $notification->user_id  = $event->user_id;
            $notification->is_choice  = $event->is_choice;
            $notification->content  = $event->content;
            $notification->accept_url  = $event->accept_url;
            $notification->reject_url  = $event->reject_url;
            $notification->redirect_url  = $event->redirect_url;
            $notification->is_seen  = $event->is_seen;
            $notification->save();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
        }

    }
}
