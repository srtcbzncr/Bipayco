<?php

namespace App\Policies\PrepareLessons;

use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\PrepareLessons\Course;
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
}
