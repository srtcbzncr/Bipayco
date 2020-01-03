<?php

namespace App\Policies\GeneralEducation;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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

    public function create(User $user, Course $course){
        if($user->can('entry', $course)){
            if(Comment::where('user_id', $user->id)->where('course_id', $course->id)->get()->count() > 0){
                Response::deny('Bu kursa daha önce yorum yaptınız.');
            }
            else{
                Response::allow();
            }
        }
        else{
            Response::deny('Kursa kayıtlı olmadığınız için yorum yapamazsınız.');
        }
    }
}
