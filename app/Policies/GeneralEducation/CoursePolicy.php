<?php

namespace App\Policies\GeneralEducation;

use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user){
        if($user->instructor->where('active', true)->first() != null){
            return true;
        }
        else{
            return false;
        }
    }

    public function checkManager(User $user, Course $course){
        $instructor = Instructor::where('user_id',$user->id)->first();
        if($instructor != null){
            $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
            ->where('instructor_id',$instructor->id)->first();
            if($geCourseInstructor != null){
                if($geCourseInstructor->is_manager == 1){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function checkInstructor(User $user, Course $course){ // checkManager metodundan farkı sadece o kursun eğitimci olup olmadığını kontrol ediyor.
        $instructor = Instructor::where('user_id',$user->id)->first();
        if($instructor != null){
            $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
                ->where('instructor_id',$instructor->id)->first();
            if($geCourseInstructor != null){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function delete(User $user, Course $course){
        return true;
    }

    public function entry(User $user, Course $course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type','App\Models\GeneralEducation\Course')->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }

    public function comment(User $user, Course $course){
        if($user->can('entry', $course)){
            if(Comment::where('user_id', $user->id)->where('course_id', $course->id)->where('course_type', get_class($course))->get()->count() == 0){
                return true;
            }
        }
        return false;
    }

    public function geAnswer(User $user, Course $course){
        $instructor = Instructor::where('user_id',$user->id)->firstOrFail();
        $control = DB::table('ge_courses_instructors')->where('instructor_id',$instructor->id)
            ->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
        if($control == null){
            return false;
        }
        else if(count($control) == 0)
            return false;
        else{
            return true;
        }
    }

    public function plAnswer(User $user, \App\Models\PrepareLessons\Course $course){
        $instructor = Instructor::where('user_id',$user->id)->firstOrFail();
        $control = DB::table('ge_courses_instructors')->where('instructor_id',$instructor->id)
            ->where('course_id',$course->id)->where('course_type','App\Models\PrepareLessons\Course')->get();
        if($control == null){
            return false;
        }
        else if(count($control) == 0)
            return false;
        else{
            return true;
        }
    }

    public function geAsk(User $user, Course $course){
        $student = Student::where('user_id',$user->id)->firstOrFail();
        $control = Entry::where('student_id',$student->id)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
        if($control == null){
            return false;
        }
        else if(count($control) == 0)
            return false;
        else{
            return true;
        }
    }
}
