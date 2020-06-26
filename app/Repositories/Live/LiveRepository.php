<?php


namespace App\Repositories\Live;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\Live\Course;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use BigBlueButton\Parameters\CreateMeetingParameters;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class LiveRepository  implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{

        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function createLiveOnBipayco($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = new Course();
            $imagePath = Storage::url($data['image']->store('public/images'));
            $object->image = $imagePath;
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price_with_discount'];
            $object->datetime = $data['datetime'];
            $object->max_participant = $data['max_participant'];
            $object->attendee_pw = uniqid('at'.random_int(100,999), false);;
            $object->moderator_pw = uniqid('mo'.random_int(100,999), false);;
            $object->record = false;
            $object->duration = $data['duration'];
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function createLiveOnBBB($user_id,$meeting_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $live = Course::find($meeting_id);
            $object = new CreateMeetingParameters($meeting_id, $live->name);
            $object->setModeratorPassword($live->moderator_pw);
            $object->setAttendeePassword($live->attendee_pw);
            $object->setDuration($live->duration);
            $object->setMaxParticipants($live->max_participant);

            $object->setBreakout(false); # dinlenme odası yok bu yüzden aşağıdaki brekout verileri direkt default 0 verdim.
            $object->setFreeJoin(false);

            BigBlueButton::create($object);
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function joinLive($user_id,$meeting_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = User::find($user_id);
            $live = Course::find($meeting_id);
            if($live->user_id ==$user_id){
                BigBlueButton::join([
                    'meetingID' => $meeting_id,
                    'fullName' => $user->first_name.' '.$user->last_name,
                    'password' => $live->moderator_pw, //which user role want to join set password here
                    'redirect' => false, //it will not redirect into bigblueservr
                ]);
            }
            else{
                BigBlueButton::join([
                    'meetingID' => $meeting_id,
                    'fullName' => $user->first_name.' '.$user->last_name,
                    'password' => $live->attendee_pw, //which user role want to join set password here
                    'redirect' => false, //it will not redirect into bigblueservr
                ]);
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
