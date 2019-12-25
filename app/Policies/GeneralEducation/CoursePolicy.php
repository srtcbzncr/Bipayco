<?php

namespace App\Policies\GeneralEducation;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        return true;
    }

    public function delete(User $user, Course $course){
        return true;
    }

    public function entry(User $user, Course $course){
        $now = date('Y-m-d HH:MM:SS', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_id', $course->id)->where('access_start', '<=', $now)->where('access_finish', '>=', $now)->where('active', true)->first();
        if($entry != null){
            return true;
        }
        else{
            return false;
        }
    }
}
