<?php


namespace App\Repositories\UserOperations;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\Base\City;
use App\Models\Base\District;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Purchase;
use App\Models\UsersOperations\Basket;
use App\Payment\Payment;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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
            else if($data['module_name'] == 'prepareExams'){
                $basket->course_type = 'App\Models\PrepareExams\Course';
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
            else if($data['module_name'] == 'prepareExams')
                $type = "App\Models\PrepareExams\Course";

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
                else if($item->course_type == "App\Models\PrepareExams\Course"){
                    $courses[$key]['course_type'] = "prepareExams";
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
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

                    $course = \App\Models\GeneralEducation\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
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
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
                else if($item['course_type'] == "prepareExams"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareExams\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareExams\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\PrepareExams\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
            }

            // delete all data that user has
            DB::table('basket')->where('user_id',$userId)->delete();
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

    public function referenceControl($referenceCode){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $instructor = Instructor::where('reference_code',$referenceCode)->where('active',true)
                ->where('deleted_at',null)->first();
            if($instructor != null){
                $object = true;
            }
            else{
                $object = false;
            }

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function checkOut($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            #preapre checkOut methot
            $user = User::find($data['user_id']);
            $ip = Request::ip();
            $disctrict = District::find($user->district_id);
            $city = City::find($disctrict->city_id);
            $basket = Basket::where('user_id',$data['user_id'])->get();
            $courses = array();
            foreach ($basket as $item){
                if($item->course_type == "App\Models\GeneralEducation\Course"){
                    $course = Course::find($item->course_id);
                    array_push($courses,$course);
                }
                else if($item->course_type == "App\Models\PrepareLessons\Course"){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    array_push($courses,$course);
                }
                else if($item->course_type == "App\Models\PrepareExams\Course"){
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    array_push($courses,$course);
                }
            }

            $payment = new Payment();
            $payment_result = $payment->checkOut($data['user_id'],$user->first_name,$user->last_name,$user->phone_number,$user->email,$data['identity_number'],
                $ip,$disctrict->city_id,$data['zip_code'],$city->country_id,$data['address'],$data['price'],$data['pricePaid'],$courses,$data['is_discount']);
            if($payment_result->getStatus() == "success"){
                $object = $payment_result->getCheckoutFormContent();
            }
            else{
                $error = $payment_result->getErrorMessage();
            }

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
