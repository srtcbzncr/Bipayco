<?php


namespace App\Repositories\UserOperations;


use App\Models\UsersOperations\Basket;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class BasketRepository implements IRepository
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

    public function add($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $basket = new Basket();
            $basket->user_id = $data['user_id'];
            $basket->course_id = $data['course_id'];
            if($data['module_name'] == 'generalEducation'){
                $basket->course_type = 'App\Models\GeneralEducation\Course';
            }
            else if($data['module_name'] == 'prepareLessons'){
                $basket->course_type = 'App\Models\PrepareLessons\Course';
            }
            else if($data['module_name'] == 'pe'){
            }
            else if($data['module_name'] == 'pre'){
            }
            else if($data['module_name'] == 'qb'){
            }
            else if($data['module_name'] == 'hw'){
            }
            $basket->save();

            DB::commit();
        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function remove($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();

            $type = "";
            if($data['module_name'] == 'generalEducation')
                $type = "App\Models\GeneralEducation\Course";
            else if($data['module_name'] == 'prepareLessons')
                $type = "App\Models\PrepareLessons\Course";

            DB::table('basket')->where('user_id',$data['user_id'])
                ->where('course_id',$data['course_id'])
                ->where('course_type',$type)->delete();

            DB::commit();
        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function show($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $courses = Basket::where('user_id',$user_id)->get();
            $object = $courses;

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
