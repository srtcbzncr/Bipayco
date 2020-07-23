<?php


namespace App\Repositories\Admin;


use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\Curriculum\Exam;
use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\Curriculum\Subject;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Section;
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
            $object = Course::where('deleted_at',null)->paginate(9);
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
            $object = \App\Models\PrepareLessons\Course::where('deleted_at',null)->paginate(9);
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
            $object = \App\Models\PrepareExams\Course::where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $exam = Exam::find($item->exam_id);

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

    public function deleteGeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::find($course_id);
            $entries = Entry::where('course_id',$course_id)->where('course_type','App\Models\GeneralEducation\Course')
                ->where('active',true)->where('deleted_at',null)->get();
            if($entries!= null and count($entries)>0){
                $error = "Kurs kayıtlı öğrenci olduğu için silinemez.";
                $result = false;
            }
            else{
                $object->delete();
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

    public function deletePlCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareLessons\Course::find($course_id);
            $entries = Entry::where('course_id',$course_id)->where('course_type','App\Models\PrepareLessons\Course')
                ->where('active',true)->where('deleted_at',null)->get();
            if($entries!= null and count($entries)>0){
                $error = "Kurs kayıtlı öğrenci olduğu için silinemez.";
                $result = false;
            }
            else{
                $object->delete();
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

    public function deletePeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareExams\Course::find($course_id);
            $entries = Entry::where('course_id',$course_id)->where('course_type','App\Models\PrepareExams\Course')
                ->where('active',true)->where('deleted_at',null)->get();
            if($entries!= null and count($entries)>0){
                $error = "Kurs kayıtlı öğrenci olduğu için silinemez.";
                $result = false;
            }
            else{
                $object->delete();
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

    public function deleteLiveCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\Live\Course::find($course_id);
            $entries = \App\Models\Live\Entry::where('live_course_id',$course_id)->where('deleted_at',null)->get();
            if($entries!= null and count($entries)>0){
                $error = "Kurs kayıtlı öğrenci olduğu için silinemez.";
                $result = false;
            }
            else{
                $object->delete();
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

    public function detailGeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::find($course_id);
            $category = Category::find($object->category_id);
            $sub_cat = Category::find($object->sub_category_id);
            $object['course_type'] = 'ge';
            $object['category'] = $category;
            $object['sub_category'] = $sub_cat;

            $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('course_type','App\Models\GeneralEducation\Course')->where('deleted_at',null)->get();
            $instructor = null;
            foreach ($ge_instructor_course as $item){
                if($item->is_manager == true){
                    $instructor = Instructor::find($item->instructor_id);
                    $user = User::find($instructor->user_id);
                    $instructor['user'] = $user;
                    break;
                }
            }

            $object['instructor'] = $instructor;

            $sections = Section::where('course_id',$course_id)->where('active',true)->where('deleted_at',null)->orderBy('no','asc')->get();
            foreach ($sections as $key => $section){
                $lessons = \App\Models\GeneralEducation\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)
                    ->orderBy('no','asc')->get();
                $sections[$key]['lessons'] = $lessons;
            }

            $object['sections'] = $sections;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function detailPlCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareLessons\Course::find($course_id);
            $lesson = Lesson::find($object->lesson_id);
            $grade = Grade::find($object->grade_id);
            $object['course_type'] = 'pl';
            $object['lesson'] = $lesson ;
            $object['grade'] = $grade;

            $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('course_type','App\Models\PrepareLessons\Course')->where('deleted_at',null)->get();
            $instructor = null;
            foreach ($ge_instructor_course as $item){
                if($item->is_manager == true){
                    $instructor = Instructor::find($item->instructor_id);
                    $user = User::find($instructor->user_id);
                    $instructor['user'] = $user;
                    break;
                }
            }

            $object['instructor'] = $instructor;

            $sections = \App\Models\PrepareLessons\Section::where('course_id',$course_id)->where('active',true)->where('deleted_at',null)->orderBy('no','asc')->get();
            foreach ($sections as $key => $section){
                $subject = Subject::find($section->subject_id);
                $lessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)
                    ->orderBy('no','asc')->get();
                $sections[$key]['subject'] = $subject;
                $sections[$key]['lessons'] = $lessons;
            }

            $object['sections'] = $sections;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function detailPeCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\PrepareExams\Course::find($course_id);
            $exam = Lesson::find($object->exam_id);
            $object['course_type'] = 'pe';
            $object['exam'] = $exam ;

            $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('course_type','App\Models\PrepareExams\Course')->where('deleted_at',null)->get();
            $instructor = null;
            foreach ($ge_instructor_course as $item){
                if($item->is_manager == true){
                    $instructor = Instructor::find($item->instructor_id);
                    $user = User::find($instructor->user_id);
                    $instructor['user'] = $user;
                    break;
                }
            }

            $object['instructor'] = $instructor;

            $sections = \App\Models\PrepareLessons\Section::where('course_id',$course_id)->where('active',true)->where('deleted_at',null)->orderBy('no','asc')->get();
            foreach ($sections as $key => $section){
                $lesson = Lesson::find($section->lesson_id);
                $subject = Subject::find($section->subject_id);
                $lessons = \App\Models\PrepareExams\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)
                    ->orderBy('no','asc')->get();
                $sections[$key]['lesson'] = $lesson;
                $sections[$key]['subject'] = $subject;
                $sections[$key]['lessons'] = $lessons;
            }

            $object['sections'] = $sections;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function detailLiveCourse($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\Live\Course::find($course_id);
            $object['course_type'] = 'live';

            $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
            $instructor = null;
            foreach ($ge_instructor_course as $item){
                if($item->is_manager == true){
                    $instructor = Instructor::find($item->instructor_id);
                    $user = User::find($instructor->user_id);
                    $instructor['user'] = $user;
                    break;
                }
            }

            $object['instructor'] = $instructor;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function studentsGe($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('course_id',$course_id)->where('course_type','App\Models\GeneralEducation\Course')
                ->where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $student['user'] = $user;
                $object[$key]->student = $student;
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

    public function studentsPl($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('course_id',$course_id)->where('course_type','App\Models\PrepareLessons\Course')
                ->where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $student['user'] = $user;
                $object[$key]->student = $student;
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

    public function studentsPe($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('course_id',$course_id)->where('course_type','App\Models\PrepareExams\Course')
                ->where('active',true)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $student['user'] = $user;
                $object[$key]->student = $student;
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

    public function studentsLive($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = \App\Models\Live\Entry::where('live_course_id',$course_id)->where('deleted_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $student['user'] = $user;
                $object[$key]->student = $student;
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
