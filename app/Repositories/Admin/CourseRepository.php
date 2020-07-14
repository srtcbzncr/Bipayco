<?php


namespace App\Repositories\Admin;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\Course;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class CourseRepository implements IRepository {

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

    public function geAllCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $category = Category::find($item->category_id);
                $subCat = Category::find($item->sub_category_id);

                $object[$key]->category = $category;
                $object[$key]->sub_category = $subCat;

                $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$item->id)
                    ->where('course_type','App\Models\GeneralEducation\Course')->where('deleted_at',null)->get();
                $instructor = null;
                foreach ($ge_instructor_course as $item2){
                    if($item2->is_manager == true){
                        $instructor = Instructor::find($item2->instructor_id);
                        $user = User::find($instructor->user_id);
                        $instructor['user'] = $user;
                        break;
                    }
                }

                $object[$key]->instructor = $instructor;
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

    public function plAllCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareLessons\Course::where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $lesson = Lesson::find($item->lesson_id);
                $grade = Grade::find($item->grade_id);

                $object[$key]->lesson = $lesson;
                $object[$key]->grade = $grade;

                $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$item->id)
                    ->where('course_type','App\Models\PrepareLessons\Course')->where('deleted_at',null)->get();
                $instructor = null;
                foreach ($ge_instructor_course as $item2){
                    if($item2->is_manager == true){
                        $instructor = Instructor::find($item2->instructor_id);
                        $user = User::find($instructor->user_id);
                        $instructor['user'] = $user;
                        break;
                    }
                }

                $object[$key]->instructor = $instructor;
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

    public function peAllCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareExams\Course::where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $exam = Lesson::find($item->exam_id);

                $object[$key]->exam = $exam;

                $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$item->id)
                    ->where('course_type','App\Models\PrepareExams\Course')->where('deleted_at',null)->get();
                $instructor = null;
                foreach ($ge_instructor_course as $item2){
                    if($item2->is_manager == true){
                        $instructor = Instructor::find($item2->instructor_id);
                        $user = User::find($instructor->user_id);
                        $instructor['user'] = $user;
                        break;
                    }
                }

                $object[$key]->instructor = $instructor;
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

    public function liveAllCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\Live\Course::where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$item->id)
                    ->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
                $instructor = null;
                foreach ($ge_instructor_course as $item2){
                    if($item2->is_manager == true){
                        $instructor = Instructor::find($item2->instructor_id);
                        $user = User::find($instructor->user_id);
                        $instructor['user'] = $user;
                        break;
                    }
                }

                $object[$key]->instructor = $instructor;
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

    public function activeGeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
           $object = Course::find($course_id);
           $object->active = true;
           $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activePlCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareLessons\Course::find($course_id);
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activePeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareExams\Course::find($course_id);
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function passiveGeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::find($course_id);
            $object->active = false;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function passivePlCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareLessons\Course::find($course_id);
            $object->active = false;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function passivePeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareExams\Course::find($course_id);
            $object->active = false;
            $object->save();
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
