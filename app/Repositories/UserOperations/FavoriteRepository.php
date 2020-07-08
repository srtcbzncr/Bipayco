<?php


namespace App\Repositories\UserOperations;


use App\Models\Curriculum\Exam;
use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\SubCategory;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class FavoriteRepository implements IRepository
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
            $favorite = new Favorite();
            $favorite->user_id = $data['user_id'];
            $favorite->course_id = $data['course_id'];
            if($data['module_name'] == 'generalEducation'){
                $favorite->course_type = 'App\Models\GeneralEducation\Course';
            }
            else if($data['module_name'] == 'prepareLessons'){
                $favorite->course_type = 'App\Models\PrepareLessons\Course';
            }
            else if($data['module_name'] == 'prepareExams'){
                $favorite->course_type = 'App\Models\PrepareExams\Course';
            }
            else if($data['module_name'] == 'live'){
                $favorite->course_type = 'App\Models\Live\Course';
            }
            else if($data['module_name'] == 'pre'){
            }
            else if($data['module_name'] == 'qb'){
            }
            else if($data['module_name'] == 'hw'){
            }
            $favorite->save();

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
            else if($data['module_name'] == 'live')
                $type = "App\Models\Live\Course";

            DB::table('favorite')->where('user_id',$data['user_id'])
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

            $courses = Favorite::where('user_id',$user_id)->get();
            $object = $courses;

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLastFavorite($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $courses = Favorite::where('user_id',$user_id)->orderBy('created_at','desc')->take(9)->get();
            $object = array();
            foreach ($courses as $key=> $course){
                if($course->course_type == 'App\Models\GeneralEducation\Course'){
                    $tempCourse = Course::find($course->id);
                    $tempCourse['course_type'] = 'generalEducation';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $category = Category::find($tempCourse->category_id);
                    $subCategory = SubCategory::find($tempCourse->sub_category_id);
                    $tempCourse['category'] = $category;
                    $tempCourse['subCategory'] = $subCategory;
                    $courses[$key]['course'] = $tempCourse;
                }
                else if($course->course_type == 'App\Models\PrepareLessons\Course'){
                    $tempCourse = \App\Models\PrepareLessons\Course::find($course->id);
                    $tempCourse['course_type'] = 'prepareLessons';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\PrepareLessons\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $lesson = Lesson::find($tempCourse->lesson_id);
                    $grade = Grade::find($tempCourse->grade_id);
                    $tempCourse['lesson'] = $lesson;
                    $tempCourse['grade'] = $grade;
                    $courses[$key]['course'] = $tempCourse;
                }
                else if($course->course_type == 'App\Models\PrepareExams\Course'){
                    $tempCourse = \App\Models\PrepareExams\Course::find($course->id);
                    $tempCourse['course_type'] = 'prepareExams';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $exam = Exam::find($tempCourse->exam_id);
                    $tempCourse['exam'] = $exam;
                    $courses[$key]['course'] = $tempCourse;
                }
                else if($course->course_type == 'App\Models\Live\Course'){
                    $tempCourse = \App\Models\Live\Course::find($course->id);
                    $tempCourse['course_type'] = 'live';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\Live\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $courses[$key]['course'] = $tempCourse;
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

    public function getFavoritePaginate($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $courses = Favorite::where('user_id',$user_id)->paginate(9);
            $object = array();
            foreach ($courses as $key=> $course){
                if($course->course_type == 'App\Models\GeneralEducation\Course'){
                    $tempCourse = Course::find($course->id);
                    $tempCourse['course_type'] = 'generalEducation';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $category = Category::find($tempCourse->category_id);
                    $subCategory = SubCategory::find($tempCourse->sub_category_id);
                    $tempCourse['category'] = $category;
                    $tempCourse['subCategory'] = $subCategory;
                    $courses[$key]['course'] = $tempCourse;

                }
                else if($course->course_type == 'App\Models\PrepareLessons\Course'){
                    $tempCourse = \App\Models\PrepareLessons\Course::find($course->id);
                    $tempCourse['course_type'] = 'prepareLessons';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\PrepareLessons\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $lesson = Lesson::find($tempCourse->lesson_id);
                    $grade = Grade::find($tempCourse->grade_id);
                    $tempCourse['lesson'] = $lesson;
                    $tempCourse['grade'] = $grade;
                    $courses[$key]['course'] = $tempCourse;
                }
                else if($course->course_type == 'App\Models\PrepareExams\Course'){
                    $tempCourse = \App\Models\PrepareExams\Course::find($course->id);
                    $tempCourse['course_type'] = 'prepareExams';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $exam = Exam::find($tempCourse->exam_id);
                    $tempCourse['exam'] = $exam;
                    $courses[$key]['course'] = $tempCourse;
                }
                else if($course->course_type == 'App\Models\Live\Course'){
                    $tempCourse = \App\Models\Live\Course::find($course->id);
                    $tempCourse['course_type'] = 'live';
                    $basketControl = Basket::where('user_id',$user_id)->where('course_id',$course->id)->where('course_type','App\Models\Live\Course')->get();
                    if($basketControl !=null and count($basketControl)>0){
                        $tempCourse['inBasket'] = true;
                    }
                    else{
                        $tempCourse['inBasket'] = false;
                    }
                    $tempCourse['inFavorite'] = true;
                    $courses[$key]['course'] = $tempCourse;
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
}
