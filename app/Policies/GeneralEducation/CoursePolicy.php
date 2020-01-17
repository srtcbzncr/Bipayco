<?php

namespace App\Policies\GeneralEducation;

use App\Models\Auth\Instructor;
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

    public function update(User $user, Course $course){
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
        $now = date('Y-m-d HH:MM:SS', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_id', $course->id)->where('course_type', get_class($course))->where('access_start', '<=', $now)->where('access_finish', '>=', $now)->where('active', true)->first();
        if($entry != null){
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
}
