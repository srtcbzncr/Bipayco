<?php

namespace App\Policies\Discussion;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstructorPolicy
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

    public function geAnswer(User $user,Course $course){
        return true;
    }

    public function plAnswer(User $user,\App\Models\PrepareLessons\Course $course){

    }
}
