<?php


namespace App\Repositories\UserOperations;


use App\Models\Auth\GuardianUser;
use App\Models\UsersOperations\Notification;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            $object = Notification::find($id);
        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $object = Notification::find($id);
            $object->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function createNotification($userId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $object = new Notification();
            $object->user_id = $data['userId'];
            $object->is_choice = $data['isChoice'];
            $object->content = $data['content'];
            $object->accept_url = null;
            $object->reject_url = null;
            $object->redirect_url = $data['redirectUrl'];
            $object->is_seen = $data['isSeen'];
            $object->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function show($userId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            $object = Notification::where('user_id',$userId)
                ->where('is_seen',false)
                ->where('deleted_at',null)->paginate(10);
        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function seen($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $object = Notification::find($id);
            $object->is_seen = true;
            $object->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function acceptGuardian($studentId,$guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $object = GuardianUser::where('guardian_id',$guardianId)->where('student_id',$studentId)->where('deleted_at',null)->first();
            $object->active = true;
            $object->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function rejectGuardian($studentId,$guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $object = GuardianUser::where('guardian_id',$guardianId)->where('student_id',$studentId)->where('deleted_at',null)->first();
            $object->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
