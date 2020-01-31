<?php


namespace App\Repositories\UserOperations;


use App\Models\UsersOperations\LastWatchedCourses;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class UserOperations implements IRepository
{

    public function all()
    {
        // TODO: Implement all() method.
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

    public function getLastWatchedCourses($student_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            $object = LastWatchedCourses::where('student_id',$student_id)->get();
            if($object==null){
                $object=array();
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
