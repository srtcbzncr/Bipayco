<?php

namespace App\Policies\Live;

use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\Live\Course;
use App\Models\Live\Entry;
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

    public function checkManager(User $user, Course $course){
        $instructor = Instructor::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($instructor != null){
            $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
                ->where('instructor_id',$instructor->id)->where('course_type','App\Models\Live\Course')->first();
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

    public function entryControl(User $user, Course $course){
        $student = Student::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        $entryControl = Entry::where('live_course_id',$course->id)->where('deleted_at',null)->where('student_id',$student->id);
        if($entryControl != null){
            return true;
        }
        else{
            return false;
        }
    }
}
