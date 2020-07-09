<?php


namespace App\Repositories\Admin;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Purchase;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class DashboardRepository implements IRepository{

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
            $error = $e->getMessage();
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

    public function getDataForDashboard($admin_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            // get user count and last 5 user
            $users = User::where('active',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $user_count = count($users);
            $object['users_count'] = $user_count;
            $object['last_users'] = $users->take(5);

            // get instructor count and last 5 instructor
            $instructors = Instructor::where('active',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $instructor_count = count($instructors);
            $last_instructors = $instructors->take(5);
            foreach ($last_instructors as $key => $item){
                $temp_user = User::find($item->user_id);
                $last_instructors[$key]['user'] = $temp_user;
            }
            $object['instructors_count'] = $instructor_count;
            $object['last_instructors'] = $last_instructors;

            // get ge course count and last 5 ge course
            $ge_courses = Course::where('active',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $ge_courses_count = count($ge_courses);
            $last_ge_courses = $ge_courses->take(5);
            $object['ge_courses_count'] = $ge_courses_count;
            $object['last_ge_courses'] = $last_ge_courses;

            // get pl course count and last 5 pl course
            $pl_courses = \App\Models\PrepareLessons\Course::where('active',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $pl_courses_count = count($pl_courses);
            $last_pl_courses = $pl_courses->take(5);
            $object['pl_courses_count'] = $pl_courses_count;
            $object['last_pl_courses'] = $last_pl_courses;

            // get pe course count and last 5 pe course
            $pe_courses = \App\Models\PrepareExams\Course::where('active',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $pe_courses_count = count($pe_courses);
            $last_pe_courses = $pe_courses->take(5);
            $object['pe_courses_count'] = $pe_courses_count;
            $object['last_pe_courses'] = $last_pe_courses;

            // get purchase count and last 5 purchase
            $purchases = Purchase::where('confirmation',true)->where('deleted_at',null)->orderBy('created_at','desc')->get();
            $purchases_count = count($purchases);
            $last_purchases = $purchases->take(5);
            foreach ($last_purchases as $key => $item){
                $temp_user = User::find($item->user_id);
                $last_purchases[$key]['user'] = $temp_user;
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $temp_course = Course::find($item->course_id);
                    $last_purchases[$key]['course'] = $temp_course;
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $temp_course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    $last_purchases[$key]['course'] = $temp_course;
                }
                else if($item->course_type == 'App\Models\PrepareExams\Course'){
                    $temp_course = \App\Models\PrepareExams\Course::find($item->course_id);
                    $last_purchases[$key]['course'] = $temp_course;
                }
                else if($item->course_type == 'App\Models\Live\Course'){
                    $temp_course = \App\Models\Live\Course::find($item->course_id);
                    $last_purchases[$key]['course'] = $temp_course;
                }
            }
            $object['purchases_count'] = $purchases_count;
            $object['last_purchases'] = $last_purchases;
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
