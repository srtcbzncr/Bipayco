<?php


namespace App\Repositories\UserOperations;


use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Purchase;
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

    public function removeAll($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            DB::table('basket')->where('user_id',$user_id)->delete();

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
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
            foreach ($courses as $key => $item){
                if($item->course_type == "App\Models\GeneralEducation\Course"){
                    $courses[$key]['course_type'] = "generalEducation";
                    $course = Course::find($item->course_id);
                    $courses[$key]['course'] = $course;
                }
                else if($item->course_type == "App\Models\PrepareLessons\Course"){
                    $courses[$key]['course_type'] = "prepareLessons";
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    $courses[$key]['course'] = $course;
                }
            }
            $object = $courses;

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function buy($userId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            foreach ($data['cart'] as $item){
                // öğrenciyi purchase tablosuna kaydet.
                if($item['course_type'] == "generalEducation"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\GeneralEducation\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\GeneralEducation\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\PrepareLessons\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
                else if($item['course_type'] == "prepareLessons"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareLessons\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareLessons\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\PrepareLessons\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
            }
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
